<?php

declare(strict_types=1);

namespace loophp\phposinfo;

use Exception;
use loophp\phposinfo\Enum\Family;
use loophp\phposinfo\Enum\FamilyName;
use loophp\phposinfo\Enum\Os;
use loophp\phposinfo\Enum\OsName;

use function define;
use function defined;
use function is_string;

use const PHP_OS;
use const PHP_OS_FAMILY;

final class OsInfo implements OsInfoInterface
{
    public static function arch(): string
    {
        return php_uname('m');
    }

    public static function family(): string
    {
        return sprintf('%s', FamilyName::value(Family::key(self::detectFamily())));
    }

    public static function hostname(): string
    {
        return php_uname('n');
    }

    public static function isApple(): bool
    {
        return self::isFamily(Family::DARWIN);
    }

    public static function isBSD(): bool
    {
        return self::isFamily(Family::BSD);
    }

    public static function isFamily($family): bool
    {
        $detectedFamily = self::detectFamily();

        if (is_string($family)) {
            $family = self::normalizeConst($family);

            if (!Family::has($family)) {
                return false;
            }

            $family = Family::value($family);
        }

        return $detectedFamily === $family;
    }

    public static function isOs($os): bool
    {
        $detectedOs = self::detectOs();

        if (is_string($os)) {
            $os = self::normalizeConst($os);

            if (!Os::has($os)) {
                return false;
            }

            $os = Os::value($os);
        }

        return $detectedOs === $os;
    }

    public static function isUnix(): bool
    {
        return self::isFamily(Family::LINUX);
    }

    public static function isWindows(): bool
    {
        return self::isFamily(Family::WINDOWS);
    }

    public static function os(): string
    {
        return sprintf('%s', OsName::value(Os::key(self::detectOs())));
    }

    public static function register(): void
    {
        $family = self::family();
        $os = self::os();

        if (!defined('PHP_OS_FAMILY')) {
            define('PHP_OS_FAMILY', $family);
        }

        if (!defined('PHP_OS')) {
            define('PHP_OS', $os);
        }

        if (!defined('PHPOSINFO_OS_FAMILY')) {
            define('PHPOSINFO_OS_FAMILY', $family);
        }

        if (!defined('PHPOSINFO_OS')) {
            define('PHPOSINFO_OS', $os);
        }
    }

    public static function release(): string
    {
        return php_uname('r');
    }

    public static function uuid(): ?string
    {
        $uuidGenerator = 'shell_exec';
        $uuidCommand = null;

        switch (self::family()) {
            case FamilyName::LINUX:
                // phpcs:disable
                $uuidCommand = '( cat /var/lib/dbus/machine-id /etc/machine-id 2> /dev/null || hostname ) | head -n 1 || :';
                // phpcs:enable

                break;
            case FamilyName::DARWIN:
                $uuidCommand = 'ioreg -rd1 -c IOPlatformExpertDevice | grep IOPlatformUUID';
                $uuidGenerator = static function (string $command) use ($uuidGenerator): ?string {
                    $output = $uuidGenerator($command);
                    $uuid = null;

                    if (null !== $output) {
                        $parts = explode('=', str_replace('"', '', $output));
                        $uuid = mb_strtolower(trim($parts[1]));
                    }

                    return $uuid;
                };

                break;
            case FamilyName::WINDOWS:
                // phpcs:disable
                $uuidCommand = '%windir%\\System32\\reg query "HKEY_LOCAL_MACHINE\\SOFTWARE\\Microsoft\\Cryptography" /v MachineGuid';
                // phpcs:enable

                break;
            case FamilyName::BSD:
                $uuidCommand = 'kenv -q smbios.system.uuid';

                break;

            default:
                $uuidGenerator = static function (?string $command): ?string {
                    return $command;
                };
        }

        return null !== $uuidCommand ? $uuidGenerator($uuidCommand) : null;
    }

    public static function version(): string
    {
        return php_uname('v');
    }

    /**
     * @throws Exception
     */
    private static function detectFamily(?int $os = null): int
    {
        $os = $os ?? self::detectOs();

        // Get the last 4 bits.
        $family = $os - (($os >> 16) << 16);

        if (true === Family::isValid($family)) {
            return $family;
        }

        if (defined(PHP_OS_FAMILY)) {
            $phpOsFamily = self::normalizeConst(PHP_OS_FAMILY);

            if (true === Family::has($phpOsFamily)) {
                return (int) Family::value($phpOsFamily);
            }
        }

        throw self::errorMessage();
    }

    /**
     * @throws Exception
     */
    private static function detectOs(): int
    {
        $oss = [
            php_uname('s'),
            PHP_OS,
        ];

        foreach ($oss as $os) {
            $os = self::normalizeConst($os);

            if (Os::has($os)) {
                return (int) Os::value($os);
            }
        }

        throw self::errorMessage();
    }

    /**
     * @throws Exception
     */
    private static function errorMessage(): Exception
    {
        $uname = php_uname();
        $os = php_uname('s');

        $message = <<<EOF
            Unable to find a proper information for this operating system.

            Please open an issue on https://github.com/loophp/phposinfo and attach the
            following information so I can update the library:

            ---8<---
            php_uname(): {$uname}
            php_uname('s'): {$os}
            --->8---

            Thanks.

            EOF;

        throw new Exception($message);
    }

    private static function normalizeConst(string $name): string
    {
        $name = (string) preg_replace('/[^a-zA-Z0-9]/', '', $name);

        return mb_strtoupper(
            str_replace('-.', '', $name)
        );
    }
}

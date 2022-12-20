<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\phposinfo\Enum;

use Exception;
use Generator;
use ReflectionClass;
use ReflectionException;

use function constant;

abstract class Enum
{
    /**
     * @return Generator<int|string>
     */
    final public static function getIterator(): Generator
    {
        $reflection = null;

        try {
            $reflection = new ReflectionClass(static::class);
        } catch (ReflectionException) {
            // Do something.
        }

        if (null !== $reflection) {
            yield from $reflection->getConstants();
        }
    }

    final public static function has(string $key): bool
    {
        foreach (static::getIterator() as $keyConst => $valueConst) {
            if ($key !== $keyConst) {
                continue;
            }

            return true;
        }

        return false;
    }

    final public static function isValid(int|string $value): bool
    {
        foreach (static::getIterator() as $valueConst) {
            if ($value !== $valueConst) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * @throws Exception
     */
    final public static function key(int|string $value): string
    {
        foreach (static::getIterator() as $keyConst => $valueConst) {
            if ($value === $valueConst) {
                return $keyConst;
            }
        }

        throw new Exception('No such key.');
    }

    final public static function value(string $value): int|string
    {
        return constant('static::' . $value);
    }
}

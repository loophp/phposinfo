<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\phposinfo\Enum;

final class FamilyName extends Enum
{
    public const BSD = 'BSD';

    public const DARWIN = 'Darwin';

    public const LINUX = 'Linux';

    public const UNIX_ON_WINDOWS = 'Unix on Windows';

    public const UNKNOWN = 'Unknown';

    public const WINDOWS = 'Windows';
}

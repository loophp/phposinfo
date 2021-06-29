<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\phposinfo\tests\Enum;

use loophp\phposinfo\Enum\Enum;

class Animals extends Enum
{
    public const CATS = 'cats';

    public const DOGS = 'dogs';
}

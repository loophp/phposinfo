<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\phposinfo\tests\Enum;

use Error;
use Exception;
use loophp\phposinfo\tests\Enum\Animals;
use PhpSpec\ObjectBehavior;

class AnimalsSpec extends ObjectBehavior
{
    public function it_can_get_a_key()
    {
        $this::has('DOGS')
            ->shouldReturn(true);

        $this::has('FOO')
            ->shouldReturn(false);

        $this::isValid('COIN')
            ->shouldReturn(false);

        $this::isValid('cats')
            ->shouldReturn(true);

        $this::key('dogs')
            ->shouldReturn('DOGS');

        $this::value('DOGS')
            ->shouldReturn('dogs');

        $this
            ->shouldThrow(Error::class)
            ->during('value', ['FOO']);

        $this
            ->shouldThrow(Exception::class)
            ->during('key', ['foo']);

        $this::getIterator()
            ->shouldYieldLike(['CATS' => 'cats', 'DOGS' => 'dogs']);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Animals::class);
    }
}

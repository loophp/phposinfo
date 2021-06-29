<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\phposinfo;

use loophp\phposinfo\Enum\Family;
use loophp\phposinfo\Enum\FamilyName;
use loophp\phposinfo\Enum\OsName;
use loophp\phposinfo\OsInfo;
use PhpSpec\ObjectBehavior;

class OsInfoSpec extends ObjectBehavior
{
    public function it_can_detect_the_os()
    {
        if (OsInfo::isUnix()) {
            $this::isFamily(Family::LINUX)
                ->shouldReturn(true);

            $this::isOs('Linux')
                ->shouldReturn(true);

            $this::isFamily('Linux')
                ->shouldReturn(true);

            $this::isOs(FamilyName::LINUX)
                ->shouldReturn(true);

            $this::isFamily(OsName::LINUX)
                ->shouldReturn(true);

            $this::os()
                ->shouldReturn('Linux');

            $this::family()
                ->shouldReturn('Linux');

            $this::isBSD()
                ->shouldReturn(false);

            $this::isOs('foo')
                ->shouldReturn(false);

            $this::isFamily('foo')
                ->shouldReturn(false);
        }

        if (OsInfo::isWindows()) {
            $this::isFamily(Family::WINDOWS)
                ->shouldReturn(true);

            $this::isOs('Windows nt')
                ->shouldReturn(true);

            $this::isFamily('Windows')
                ->shouldReturn(true);

            $this::isOs(OsName::WINDOWSNT)
                ->shouldReturn(true);

            $this::isFamily(FamilyName::WINDOWS)
                ->shouldReturn(true);

            $this::os()
                ->shouldReturn('Windows NT');

            $this::family()
                ->shouldReturn('Windows');

            $this::isBSD()
                ->shouldReturn(false);

            $this::isOs('foo')
                ->shouldReturn(false);

            $this::isFamily('foo')
                ->shouldReturn(false);
        }

        // I don't have any Apple computer so I can't test properly.
        if (OsInfo::isApple()) {
            $this::isFamily(Family::DARWIN)
                ->shouldReturn(true);

            $this::isBSD()
                ->shouldReturn(false);

            $this::isOs('foo')
                ->shouldReturn(false);

            $this::isFamily('foo')
                ->shouldReturn(false);
        }
    }

    public function it_can_get_the_uuid()
    {
        $this::uuid()
            ->shouldBeString();
    }

    public function it_can_register_constants()
    {
        $this::register()
            ->shouldReturn(null);
    }

    public function it_can_test_the_arch()
    {
        $this::arch()
            ->shouldBeString();
    }

    public function it_can_test_the_hostname()
    {
        $this::hostname()
            ->shouldBeString();
    }

    public function it_can_test_the_release()
    {
        $this::release()
            ->shouldBeString();
    }

    public function it_can_test_the_version()
    {
        $this::version()
            ->shouldBeString();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(OsInfo::class);
    }
}

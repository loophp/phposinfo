[![Latest Stable Version][latest stable version]][packagist]
[![GitHub stars][github stars]][packagist]
[![Total Downloads][total downloads]][packagist]
[![GitHub Workflow Status][github workflow status]][github actions]
[![Scrutinizer code quality][code quality]][scrutinizer code quality]
[![Type Coverage][type coverage]][sheperd type coverage]
[![Code Coverage][code coverage]][scrutinizer code quality]
[![License][license]][packagist] [![Donate!][donate github]][github sponsor]

# PHP OS Info

## Description

Get information of the current operating system where PHP is running on.

Information that you can retrieve are:

-   Operating system name
-   Operating system family
-   Machine UUID

There are many packages that does that already, but most of them are based on
the use of the variable `PHP_OS` that contains the operating system name PHP was
built on, from [php.net](https://www.php.net/manual/en/reserved.constants.php):

     The operating system PHP was built for.

However, `PHP_OS` might be sometimes not very accurate, then using
[php_uname()](https://php.net/php_uname) might be a better fit for detecting the
operating system, we only use it as a fallback.

This library uses [php_uname()](https://php.net/php_uname) and a static list of
existing operating systems, and then from there, tries to deduct the operating
system family.

From PHP 7.2, the variable `PHP_OS_FAMILY` was added and based on the definition
from [php.net](https://www.php.net/manual/en/reserved.constants.php):

     The operating system family PHP was built for.
     Either of 'Windows', 'BSD', 'Darwin', 'Solaris', 'Linux' or 'Unknown'.

So once again, if you're using a PHP which is cross compiled, using those
constant is a bad idea.

## Requirements

-   PHP >= 7.1.3

## Installation

`composer require loophp/phposinfo`

## Usage

```php
<?php

include 'vendor/autoload.php';

use loophp\phposinfo\OsInfo;
use loophp\phposinfo\Enum\Family;
use loophp\phposinfo\Enum\Os;

// Register constants if they do not exists:
// * PHP_OS_FAMILY
// * PHP_OS
// * PHPOSINFO_OS_FAMILY
// * PHPOSINFO_OS
OsInfo::register();

// Get the OS name.
OsInfo::os();

// Get the OS family.
OsInfo::family();

// Check if the OS is Unix based.
OsInfo::isUnix();

// Check if the OS is Apple based.
OsInfo::isApple();

// Check if the OS is Windows based.
OsInfo::isWindows();

// Check the OS version.
OsInfo::version();

// Check the OS release.
OsInfo::release();

// Check if the OS Family is Family::UNIX_ON_WINDOWS.
OsInfo::isFamily(Family::UNIX_ON_WINDOWS);

// Check if the OS is Os::FREEBSD.
OsInfo::isOs(Os::FREEBSD);

// Check if the OS is Windows.
OsInfo::isOs('windows');

// Check if the OS family is darwin.
OsInfo::isFamily('darwin');

// Get the machine UUID.
OsInfo::uuid();
```

## Code quality, tests and benchmarks

Every time changes are introduced into the library,
[Github actions](https://github.com/loophp/phposinfo/actions) are setup to test
the library against different operating systems and PHP versions.

The library has tests written with [PHPSpec](http://www.phpspec.net/). Feel free
to check them out in the `spec` directory. Run `composer phpspec` to trigger the
tests.

Before each commit some inspections are executed with
[GrumPHP](https://github.com/phpro/grumphp), run `./vendor/bin/grumphp run` to
check manually.

[PHPInfection](https://github.com/infection/infection) is used to ensure that
your code is properly tested, run `composer infection` to test your code.

## Contributing

Feel free to contribute by sending pull requests. We are a usually very
responsive team and we will help you going through your pull request from the
beginning to the end.

For some reasons, if you can't contribute to the code and willing to help,
sponsoring is a good, sound and safe way to show us some gratitude for the hours
we invested in this package.

Sponsor me on [Github][github sponsors link] and/or any of [the
contributors][6].

## Changelog

See [CHANGELOG.md][43] for a changelog based on [git commits][44].

For more detailed changelogs, please check [the release changelogs][45].

[packagist]: https://packagist.org/packages/loophp/phposinfo
[latest stable version]:
    https://img.shields.io/packagist/v/loophp/phposinfo.svg?style=flat-square
[github stars]:
    https://img.shields.io/github/stars/loophp/phposinfo.svg?style=flat-square
[total downloads]:
    https://img.shields.io/packagist/dt/loophp/phposinfo.svg?style=flat-square
[github workflow status]:
    https://img.shields.io/github/actions/workflow/status/loophp/phposinfo/tests.yml?branch=master&style=flat-square
[github sponsors link]: https://github.com/sponsors/drupol
[6]: https://github.com/loophp/phposinfo/graphs/contributors
[code quality]:
    https://img.shields.io/scrutinizer/quality/g/loophp/phposinfo/master.svg?style=flat-square
[scrutinizer code quality]:
    https://scrutinizer-ci.com/g/loophp/phposinfo/?branch=master
[type coverage]:
    https://img.shields.io/badge/dynamic/json?style=flat-square&color=color&label=Type%20coverage&query=message&url=https%3A%2F%2Fshepherd.dev%2Fgithub%2Floophp%2Fphposinfo%2Fcoverage
[sheperd type coverage]: https://shepherd.dev/github/loophp/phposinfo
[code coverage]:
    https://img.shields.io/scrutinizer/coverage/g/loophp/phposinfo/master.svg?style=flat-square
[license]:
    https://img.shields.io/packagist/l/loophp/phposinfo.svg?style=flat-square
[github actions]: https://github.com/loophp/phposinfo/actions
[donate github]:
    https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[donate paypal]:
    https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[github sponsor]: https://github.com/sponsors/drupol
[paypal sponsor]: https://www.paypal.me/drupol
[43]: https://github.com/loophp/phposinfo/blob/master/CHANGELOG.md
[44]: https://github.com/loophp/phposinfo/commits/master
[45]: https://github.com/loophp/phposinfo/releases

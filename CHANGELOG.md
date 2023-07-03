# Rinvex Authy Changelog

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](CONTRIBUTING.md).


## [v7.1.1] - 2023-07-03
- Update composer dependencies

## [v7.1.0] - 2023-05-02
- Update composer dependency psr/http-message to v2.0 from v1.0
- Update phpunit to v10.1 from v9.5

## [v7.0.0] - 2023-01-09
- Drop PHP v8.0 support and update composer dependencies

## [v6.1.0] - 2022-02-14
- Update composer dependencies

## [v6.0.0] - 2021-08-22
- Drop PHP v7 support, and upgrade rinvex package dependencies to next major version
- Update composer dependencies
- Upgrade to GitHub-native Dependabot (#33)
- Update User deletion endpoint to comply with Authy (#28)
- Enable StyleCI risky mode

## [v5.0.3] - 2020-12-25
- Add support for PHP v8

## [v5.0.2] - 2020-12-22
- Update composer dependencies
- Update composer dependency mockery/mockery
- Drop PHP 7.2 & 7.3 support from travis
- Remove default indent size config

## [v5.0.1] - 2020-04-04
- Drop laravel/helpers usage as it's no longer used

## [v5.0.0] - 2020-03-15
- Upgrade to Laravel v7.1.x & PHP v7.4.x

## [v4.1.2] - 2019-03-13
- Tweak TravisCI config
- Update StyleCI config

## [v4.1.1] - 2019-09-24
- Add missing laravel/helpers composer package

## [v4.1.0] - 2019-06-02
- Update composer deps
- Drop PHP 7.1 travis test

## [v4.0.0] - 2019-03-03
- Rename environment variable QUEUE_DRIVER to QUEUE_CONNECTION
- Require PHP 7.2 & Laravel 5.8
- Apply PHPUnit 8 updates

## [v3.0.2] - 2018-12-22
- Update composer dependencies
- Add PHP 7.3 support to travis

## [v3.0.1] - 2018-09-22
- Update travis php versions
- Drop StyleCI multi-language support (paid feature now!)
- Update composer dependencies
- Prepare and tweak testing configuration
- Update StyleCI options
- Update PHPUnit options

## [v3.0.0] - 2018-02-18
- Require PHP v7.1.3
- Update supplementary files
- Update composer depedencies
- Fix deprecated PHPUnit TestCase namespace
- Add PHPUnitPrettyResultPrinter
- Typehint method returns

## [v2.1.1] - 2017-03-08
- Clean and tweak Authy Response class
- Fix auth api force query parameter data type
- Rename InvalidConfiguration namespace
- Declare functions return types

## [v2.1.0] - 2017-03-07
- Pass force flag as string true/false as per Authy API docs
- Enforce strict type declaration
- Update StyleCI fixers and other supplementary files

## [v2.0.1] - 2016-12-20
- Add upgrade guide and fix minor typo

## [v2.0.0] - 2016-12-20
- Simplify code
- Drop LTS support
- Update Code Style
- Drop Authy deprecated sandbox api support
- Push dependencies forward and require php7

## [v1.0.0] - 2016-11-17
- Commit first stable release

## [v0.0.5] - 2016-11-17
- Alias master branch for version stability requirements

## [v0.0.4] - 2016-11-16
- Fix wrong installation steps

## [v0.0.3] - 2016-11-15
- Fix wrong sensiolabs insight ID
- Fix wrong files permissions
- Add Travis shield

## [v0.0.2] - 2016-11-15
- Fix few typos

## v0.0.1 - 2016-11-15
- Tag first release

[v7.1.1]: https://github.com/rinvex/authy/compare/v7.1.0...v7.1.1
[v7.1.0]: https://github.com/rinvex/authy/compare/v7.0.0...v7.1.0
[v7.0.0]: https://github.com/rinvex/authy/compare/v6.1.0...v7.0.0
[v6.1.0]: https://github.com/rinvex/authy/compare/v6.0.0...v6.1.0
[v6.0.0]: https://github.com/rinvex/authy/compare/v5.0.3...v6.0.0
[v5.0.3]: https://github.com/rinvex/authy/compare/v5.0.2...v5.0.3
[v5.0.2]: https://github.com/rinvex/authy/compare/v5.0.1...v5.0.2
[v5.0.1]: https://github.com/rinvex/authy/compare/v5.0.0...v5.0.1
[v5.0.0]: https://github.com/rinvex/authy/compare/v4.1.2...v5.0.0
[v4.1.2]: https://github.com/rinvex/authy/compare/v4.1.1...v4.1.2
[v4.1.1]: https://github.com/rinvex/authy/compare/v4.1.0...v4.1.1
[v4.1.0]: https://github.com/rinvex/authy/compare/v4.0.0...v4.1.0
[v4.0.0]: https://github.com/rinvex/authy/compare/v3.0.2...v4.0.0
[v3.0.2]: https://github.com/rinvex/authy/compare/v3.0.1...v3.0.2
[v3.0.1]: https://github.com/rinvex/authy/compare/v3.0.0...v3.0.1
[v3.0.0]: https://github.com/rinvex/authy/compare/v2.1.1...v3.0.0
[v2.1.1]: https://github.com/rinvex/authy/compare/v2.1.0...v2.1.1
[v2.1.0]: https://github.com/rinvex/authy/compare/v2.0.1...v2.1.0
[v2.0.1]: https://github.com/rinvex/authy/compare/v2.0.0...v2.0.1
[v2.0.0]: https://github.com/rinvex/authy/compare/v1.0.0...v2.0.0
[v1.0.0]: https://github.com/rinvex/authy/compare/v0.0.5...v1.0.0
[v0.0.5]: https://github.com/rinvex/authy/compare/v0.0.4...v0.0.5
[v0.0.4]: https://github.com/rinvex/authy/compare/v0.0.3...v0.0.4
[v0.0.3]: https://github.com/rinvex/authy/compare/v0.0.2...v0.0.3
[v0.0.2]: https://github.com/rinvex/authy/compare/v0.0.1...v0.0.2

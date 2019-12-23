# Change Log
A change log for the change log parser

## Unreleased

## 0.11.0 - 2019-12-23

### Changed

- Allow `symfony/dom-crawler:5` and `symfony/css-selector:5`
- Drop support for everything below PHP 7.4

## 0.10.1 - 2019-10-05

### Changed

- [internal] Replaced Travis with GitHub actions
- [internal] Updated to PHPSpec 6

### Security

- Upgraded to `league/commonmark` to fix CVE-2019-10010

## 0.10.0 - 2018-02-25

### Changed

- Drop support for PHP5, PHP 7.1.3 is now required
- Upgrade dependencies to their latest versions

## 0.9.0 - 2016-01-01

### Changed

- Updated symfony dependencies to 3.0

## 0.8.0 - 2015-12-25

### Changed

- Updated symfony requirements to 2.8

## 0.7.1 - 2015-12-13

### Fixed

- Fixed issue where the description returned the first release if no description was given
- Better support for multi line descriptions.
- Fixed issue where the parser crashed if a release had no date (for example and `unreleased` section)

## 0.7.0 - 2015-11-25

* Updated the following dependencies to their latest versions: `league/commonmark:0.12.0`, `symfony/dom-crawler:2.7.7`, `symfony/css-selector:2.7.7`
* PSR-4 autoloading

## 0.6.2 - 2015-04-15

### Fixed

* Fix issue with empty lines being parsed

## 0.6.1 - 2015-01-09

### Fixed

* Fixed an issue where a section would sometimes be empty

## 0.6.0 - 2014-12-28

### Added

* added `.gitattributes` file to only include necessary content during a composer install

## 0.5.0 - 2014-12-25

### Changed

* getChanges and getReleases now return arrays instead of JSON

## 0.4.0 - 2014-12-24

_No notable changes_

## 0.3.0 - 2014-12-23

### Changed

* Changed the underlying Markdown parser to [league/commonmark](https://github.com/thephpleague/commonmark)

## 0.2.0 - 2014-11-22

### Added

* `getChanges` method to retrieve a single release

## 0.1.0 - 2014-11-22

### Added

* `getReleases` method that retrieves the releases described in a change log
* `toJson` method that creates a json representation of a change log.

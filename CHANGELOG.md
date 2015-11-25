# Change Log
A change log for the change log parser

## Unreleased

* Updated the following dependencies to their latest versions: `league/commonmark:0.12.0`, `symfony/dom-crawler:2.7.7`, `symfony/css-selector:2.7.7`

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

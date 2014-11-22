# Changelog
> Parse changelogs like a pro

This package makes it easy to parse change logs in the [keepachangelog.com](http://keepachangelog.com/) format

## Installation

`composer require bramdevries/changelog`

## Usage

### Parsing an entire change log

The following change log:

  ```md

  # Change Log
  A change log for the change log parser

  ## 0.2.0 - 2014-11-22

  ### Added

  * `getChanges` method to retrieve a single release

  ## 0.1.0 - 2014-11-22

  ### Added

  * `getReleases` method that retrieves the releases described in a change log
  * `toJson` method that creates a json representation of a change log.

  ```

```php
$parser = new Changelog\Parser(file_get_contents('CHANGELOG.md');
echo $parser->toJson();
```

Will return

```json
{
  "description": "A change log for the change log parser",
  "releases": [
    {
      "name": "0.0.1",
      "date": "2014-11-22",
      "changes": {
        "added": [
          "<code>getReleases</code> method that retrieves the releases described in a change log",
          "<code>toJson</code> method that creates a json representation of a change log."
        ]
      }
    }
  ]
}
```

### Parsing a single release's changelog

eg: If you want to parse a pull request in this format

```md
  ### Added
  - Addition 1
  - Addition 2

  ### Changed
  - Change 1
  - Change 2

  ### Removed
  - Removal 1
  - Removal 2
```

```php
// Assuming $content contains the above markdown
$parser = new Changelog\Parser($content);
echo $parser->getChanges();
```

returns

```json
{
  "added": [
    "Addition 1",
    "Addition 2"
  ],
  "changed": [
    "Change 1",
    "Change 2"
  ],
  "removed": [
    "Removal 1",
    "Removal 2"
  ]
}
```

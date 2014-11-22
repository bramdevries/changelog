# Changelog
> Parse changelogs like a pro

This package makes it easy to parse change logs in the [keepachangelog.com](http://keepachangelog.com/) format

## Usage

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
      "date": "2014-08-09",
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


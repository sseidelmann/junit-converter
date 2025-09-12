# junit-converter

[![Status des Workflows](https://img.shields.io/github/actions/workflow/status/sseidelmann/junit-converter/main.yml?branch=main)](https://github.com/sseidelmann/junit-converter/actions)

Ein PHP-Tool zur Konvertierung verschiedener Testausgabeformate in das JUnit-XML Format.

## Beschreibung

Dieses Tool ermöglicht die Konvertierung von verschiedenen Testausgabeformaten (Checkstyle, Sonarqube, GNU, ...) in das standardisierte JUnit-XML Format.

## Installation

Installation via Composer:
```
bash composer require sseidelmann/junit-converter
``` 

## Verwendung

### Basis-Verwendung
```
cat checkstyle.xml | junit-converter convert > junit.xml
``` 

### Unterstützte Formate

#### Checkstyle
```
$ hadolint -f checkstyle Dockerfile

<?xml version="1.0" encoding="UTF-8"?>
<checkstyle version="4.3">
    <file name="Service/Dockerfile">
        <error column="1" line="19" message="Always tag the version of an image explicitly" severity="warning" source="DL3006"/>
        <error column="1" line="29" message="Multiple consecutive `RUN` instructions. Consider consolidation." severity="info" source="DL3059"/>
    </file>
</checkstyle>
```

#### NPM Outdated (json)
```
$ npm outdated --json

{
  "@angular/animations": {
    "wanted": "14.3.0",
    "latest": "19.2.15",
    "dependent": "angular-app"
  },
  "@angular/cdk": {
    "wanted": "14.2.7",
    "latest": "20.2.3",
    "dependent": "angular-app"
  }
}
```

## Anforderungen

- PHP 8.3 oder höher
- Composer
- GIT (optional)

## Tests ausführen
```
composer install
./vendor/bin/phpunit
``` 

## Lizenz

Dieses Projekt steht unter der MIT-Lizenz. Siehe [LICENSE](LICENSE) Datei für Details.

## Author

Sebastian Seidelmann

## Copyright

© 2025 Sebastian Seidelmann

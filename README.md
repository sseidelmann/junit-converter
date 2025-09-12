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

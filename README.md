# junit-converter

[![Status des Workflows](https://img.shields.io/github/actions/workflow/status/sseidelmann/junit-converter/main.yml?branch=main)](https://github.com/sseidelmann/junit-converter/actions)
![Packagist Version](https://img.shields.io/packagist/v/sseidelmann/junit-converter)
![Packagist Stars](https://img.shields.io/packagist/stars/sseidelmann/junit-converter)


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

#### CSharpier (console)
```
$ csharpier csharpier check .

Error ./Project/Project.csproj - Was not formatted.
  ----------------------------- Expected: Around Line 2 -----------------------------
  <Project Sdk="Microsoft.NET.Sdk">
    <PropertyGroup>
      <TargetFramework>net8.0</TargetFramework>
  ----------------------------- Actual: Around Line 2 -----------------------------
  <Project Sdk="Microsoft.NET.Sdk">
  	<PropertyGroup>
  		<TargetFramework>net8.0</TargetFramework>

```

#### Dotnet packages (json)
```
$ dotnet package list --vulnerable --project <path-to-csproj> --format json

{
  "version": 1,
  "parameters": "--outdated",
  "sources": [
    "https://api.nuget.org/v3/index.json"
  ],
  "projects": [
    {
      "path": "/path/to/project.csproj",
      "frameworks": [
        {
          "framework": "net8.0",
          "topLevelPackages": [
            {
              "id": "Microsoft.Extensions.DependencyInjection",
              "requestedVersion": "8.0.1",
              "resolvedVersion": "8.0.1",
              "latestVersion": "9.0.9"
            },
            {
              "id": "Microsoft.Extensions.Http",
              "requestedVersion": "8.0.1",
              "resolvedVersion": "8.0.1",
              "latestVersion": "9.0.9"
            }
          ]
        }
      ]
    }
  ]
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

## PHP Codestyle
```
composer install
./vendor/bin/php-cs-fixer fix --allow-risky=yes
```

## Lizenz

Dieses Projekt steht unter der MIT-Lizenz. Siehe [LICENSE](LICENSE) Datei für Details.

## Author

Sebastian Seidelmann

## Copyright

© 2025 Sebastian Seidelmann

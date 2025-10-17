<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Factories;

use Sseidelmann\JunitConverter\Converters\Checkstyle\Converter as CheckstyleConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\Converters\CsharpierConsole\Converter as CsharpierConsoleConverter;
use Sseidelmann\JunitConverter\Converters\DotnetPackageListJson\Converter as DotnetPackageListJsonConverter;
use Sseidelmann\JunitConverter\Converters\Gnu\Converter as GnuConverter;
use Sseidelmann\JunitConverter\Converters\NpmOutdatedJson\Converter as NpmOutdatedJsonConverter;
use Sseidelmann\JunitConverter\Converters\Sonarqube\Converter as SonarqubeConverter;
use Sseidelmann\JunitConverter\Converters\Sarif\Converter as SarifConverter;

class ConverterFactory
{
    /** @var ConverterInterface[] */
    private static array $converters = [
        CheckstyleConverter::class,
        DotnetPackageListJsonConverter::class,
        NpmOutdatedJsonConverter::class,
        SonarqubeConverter::class,
        GnuConverter::class,
        CsharpierConsoleConverter::class,
        SarifConverter::class,
    ];

    public function guessConverter(string $input, array $listOfConverters = []): ?ConverterInterface {
        $converters = $this->getConverter($input);

        if (count($listOfConverters) > 0) {
            foreach ($converters as $name => $converter) {
                if (!in_array($name, $listOfConverters)) {
                    unset($converters[$name]);
                }
            }
        }

        foreach ($converters as $converter) {
            if ($converter->isReport()) {
                return $converter;
            }
        }

        return null;
    }

    /**
     * @return ConverterInterface[]
     */
    private function getConverter(string $input): array {
        $converterClasses = [];
        foreach (self::$converters as $converterClass) {
            $converterInstance = new $converterClass($input);
            $converterClasses[$converterInstance->getName()] = $converterInstance;
        }

        return $converterClasses;
    }
}

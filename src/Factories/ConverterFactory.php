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

class ConverterFactory
{
    /** @var ConverterInterface[] */
    private array $converters = [
        CheckstyleConverter::class,
        DotnetPackageListJsonConverter::class,
        NpmOutdatedJsonConverter::class,
        SonarqubeConverter::class,
        GnuConverter::class,
        CsharpierConsoleConverter::class,
    ];

    public function guessConverter(string $input): ?ConverterInterface {
        foreach ($this->converters as $converterClass) {
            /** @var ConverterInterface $converter */
            $converter = new $converterClass($input);

            if ($converter->isReport()) {
                return $converter;
            }
        }

        return null;
    }

    /**
     * @return ConverterInterface[]
     */
    public function getConverter(): array {
        return array_map(function ($class) {
            return new $class('');
        }, $this->converters);
    }
}

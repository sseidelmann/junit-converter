<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Factories;

use Sseidelmann\JunitConverter\Converters\CheckstyleConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\Converters\CsharpierConsoleConverter;
use Sseidelmann\JunitConverter\Converters\DotnetPackageListJsonConverter;
use Sseidelmann\JunitConverter\Converters\GnuConverter;
use Sseidelmann\JunitConverter\Converters\NpmOutdatedJsonConverter;
use Sseidelmann\JunitConverter\Converters\SonarqubeConverter;

class ConverterFactory
{
    /** @var ConverterInterface[] */
    private array $converters = [
        CheckstyleConverter::class,
        SonarqubeConverter::class,
        GnuConverter::class,
        NpmOutdatedJsonConverter::class,
        DotnetPackageListJsonConverter::class,
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

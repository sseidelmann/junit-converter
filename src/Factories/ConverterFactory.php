<?php

namespace Sseidelmann\JunitConverter\Factories;

use Sseidelmann\JunitConverter\Converters\CheckstyleConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\Converters\GnuConverter;
use Sseidelmann\JunitConverter\Converters\SonarqubeConverter;

class ConverterFactory
{
    /** @var ConverterInterface[] $converters */
    private array $converters = [
        CheckstyleConverter::class,
        SonarqubeConverter::class,
        GnuConverter::class
    ];

    public function guessConverter(string $input): ?ConverterInterface {
        foreach ($this->converters as $converterClass) {
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
        return array_map(function ($class) {return new $class('');}, $this->converters);
    }
}
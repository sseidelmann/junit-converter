<?php

/**
 * @project Junit Converter
 * @file ConverterFactoryTests.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverterTests\Factories;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Sseidelmann\JunitConverter\Converters\Checkstyle\Converter as CheckstyleConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\Converters\Gnu\Converter as GnuConverter;
use Sseidelmann\JunitConverter\Converters\Sonarqube\Converter as SonarqubeConverter;
use Sseidelmann\JunitConverter\Factories\ConverterFactory;

class ConverterFactoryTest extends TestCase
{
    private function loadAsset(string $asset): string {
        $filePath = dirname(__FILE__) . '/../assets/' . $asset;

        return file_get_contents($filePath);
    }

    #[Test]
    public function itGuessesTheCheckstyleConverter(): void {
        $converterFactory = new ConverterFactory();

        $converter = $converterFactory->guessConverter(
            $this->loadAsset('checkstyle.xml')
        );

        $this->assertInstanceOf(CheckstyleConverter::class, $converter);
    }

    #[Test]
    public function itGuessesTheSonarqubeConverter(): void {
        $converterFactory = new ConverterFactory();

        $converter = $converterFactory->guessConverter(
            $this->loadAsset('docker_sonarqube.json')
        );

        $this->assertInstanceOf(SonarqubeConverter::class, $converter);
    }

    #[Test]
    public function itGuessesTheGnuConverter(): void {
        $converterFactory = new ConverterFactory();

        $converter = $converterFactory->guessConverter(
            $this->loadAsset('gnu.txt')
        );

        $this->assertInstanceOf(GnuConverter::class, $converter);
    }

    #[Test]
    public function itReturnsNullIfNoConverterWasFound(): void {
        $converterFactory = new ConverterFactory();

        $converter = $converterFactory->guessConverter('');

        $this->assertNull($converter);
    }

    #[Test]
    public function itHasConverters(): void {
        $converterFactory = new ConverterFactory();

        $converters = $converterFactory->getConverter();

        $this->assertNotEmpty($converters);
    }

    #[Test]
    public function itContainsConverterInterfaces(): void {
        $converterFactory = new ConverterFactory();

        $converters = $converterFactory->getConverter();

        $this->assertContainsOnlyInstancesOf(ConverterInterface::class, $converters);
    }
}

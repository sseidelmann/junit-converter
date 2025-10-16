<?php

/**
 * @project Junit Converter
 * @file CheckstyleConverterTest.php
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

namespace Sseidelmann\JunitConverterTests\Converters;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Sseidelmann\JunitConverter\Converters\CheckstyleConverter;
use Sseidelmann\JunitConverter\Converters\Converter;
use Sseidelmann\JunitConverter\JUnit\JUnit;

class CSharpierConsoleConverterTest extends TestCase
{
    private function loadAsset(string $asset): string {
        $filePath = dirname(__FILE__) . '/../assets/' . $asset;

        return file_get_contents($filePath);
    }

    #[Test]
    public function isCorrectName(): void {
        $csharpierConsoleConverter = new Converter(
            $this->loadAsset('csharpier.txt')
        );

        $this->assertEquals('csharpier', $csharpierConsoleConverter->getName());
    }

    #[Test]
    public function runsCsharpierConsoleConverterReport(): void {
        $csharpierConsoleConverter = new Converter(
            $this->loadAsset('csharpier.txt')
        );

        $this->assertTrue($csharpierConsoleConverter->isReport());
    }

    #[Test]
    public function runsCsharpierConsoleConverterReportWithNotFounds(): void {
        $csharpierConsoleConverter = new Converter(
            $this->loadAsset('csharpier_all_ok.txt')
        );

        $this->assertTrue($csharpierConsoleConverter->isReport());
    }
}

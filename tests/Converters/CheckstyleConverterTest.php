<?php
/**
 * @project Junit Converter
 * @file CheckstyleConverterTest.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverterTests\Converters;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Sseidelmann\JunitConverter\Converters\CheckstyleConverter;
use Sseidelmann\JunitConverter\JUnit\JUnit;

class CheckstyleConverterTest extends TestCase
{
    private function loadAsset(string $asset): string {
        $filePath = dirname(__FILE__) . '/../assets/' . $asset;

        return file_get_contents($filePath);
    }

    #[Test]
    public function isCorrectName(): void {
        $checkstyleConverter = new CheckstyleConverter(
            $this->loadAsset('checkstyle.xml')
        );

        $this->assertEquals('checkstyle', $checkstyleConverter->getName());
    }

    #[Test]
    public function runsCheckstyleReport(): void {
        $checkstyleConverter = new CheckstyleConverter(
            $this->loadAsset('checkstyle.xml')
        );

        $this->assertTrue($checkstyleConverter->isReport());
    }

    #[Test]
    public function convertsToJunit(): void {
        $checkstyleConverter = new CheckstyleConverter(
            $this->loadAsset('checkstyle.xml')
        );

        $this->assertInstanceOf(JUnit::class, $checkstyleConverter->convert());
    }
}
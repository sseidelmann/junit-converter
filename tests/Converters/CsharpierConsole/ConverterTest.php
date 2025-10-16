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

namespace Sseidelmann\JunitConverterTests\Converters\CsharpierConsole;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Sseidelmann\JunitConverter\Converters\CsharpierConsole\Converter;
use Sseidelmann\JunitConverterTests\Converters\AbstractConverterTestCase;

class ConverterTest extends AbstractConverterTestCase
{

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

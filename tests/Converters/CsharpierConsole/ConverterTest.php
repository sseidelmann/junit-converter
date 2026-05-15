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
use Sseidelmann\JunitConverter\Report\Report;
use Sseidelmann\JunitConverterTests\Converters\AbstractConverterTest;

class ConverterTest extends AbstractConverterTest
{
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

    #[Test]
    public function CsharpierConsoleConverter_Runs(): void {
        $csharpierConsoleConverter = new Converter(
            $this->loadAsset('csharpier.txt')
        );

        $this->assertTrue($csharpierConsoleConverter->isReport());

        $junit = $csharpierConsoleConverter->convert();

        $this->assertInstanceOf(Report::class, $junit);
    }


    /**
     * Creates the converter.
     *
     * @param array $content
     *
     * @return Converter
     */
    private function createConvert(array $content): Converter {
        return new Converter(
            implode(PHP_EOL, $content)
        );
    }

    #[Test]
    public function CsharpierConsoleConverter_Runs2(): void {
        $converter = $this->createConvert([
            'Error ./Path/To/File.cs - Was not formatted.',
            '  The file contained different line endings than formatting it would result in.',
            'Checked 3 files in 200ms.'
        ]);

        $this->assertTrue($converter->isReport());

        $report = $converter->convert();

        $this->assertEquals(1, $report->getIssueCount());
    }

    #[Test]
    public function CsharpierConsoleConverter_ChecksTheFooter_ForFiles(): void {
        $converter = $this->createConvert([
            'Error ./Path/To/File.cs - Was not formatted.',
            '  The file contained different line endings than formatting it would result in.',
            'Checked 3 files in 200ms.'
        ]);

        $this->assertTrue($converter->isReport());

        $report = $converter->convert();

        $this->assertEquals(3, $report->getMetadata()->getCheckFilesCount());
    }

    #[Test]
    public function CsharpierConsoleConverter_ChecksTheFooter_ForTheDurationInSeconds(): void {
        $converter = $this->createConvert([
            'Error ./Path/To/File.cs - Was not formatted.',
            '  The file contained different line endings than formatting it would result in.',
            'Checked 3 files in 200ms.'
        ]);

        $this->assertTrue($converter->isReport());

        $report = $converter->convert();

        $this->assertEquals(0.2, $report->getMetadata()->getDurationInSeconds());
    }
}

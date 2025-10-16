<?php
/**
 * @project Junit Converter
 * @file TextConverterTest.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverterTests\Converters\Traits\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Sseidelmann\JunitConverter\Converters\Traits\Text\TextConverter;

class TextConverterTest extends TestCase
{
    #[Test]
    public function TextConverter_GetLines_ReturnsTheCorrectAmountOfLines(): void {
        $textConverter = new TextConverter('test' . PHP_EOL . 'test');

        $this->assertCount(2, $textConverter->getLines());
    }

    #[Test]
    public function TextConverter_GetLinesWithCustomSeparator_ReturnsTheCorrectAmountOfLines(): void {
        $textConverter = new TextConverter('test---test', '---');

        $this->assertCount(2, $textConverter->getLines());
    }

    #[Test]
    public function TextConverter_GetLineAt_ReturnsTheCorrectLine(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');

        $this->assertEquals('second', $textConverter->getLineAt(1));
    }

    #[Test]
    public function TextConverter_GetLineAt_ThrowsOutOfBoundsWhenNegativ(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');

        $this->expectException(\OutOfBoundsException::class);
        $textConverter->getLineAt(-1);
    }

    #[Test]
    public function TextConverter_GetLineAt_ThrowsOutOfBoundsWhenGreaterThenSize(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');

        $this->expectException(\OutOfBoundsException::class);
        $textConverter->getLineAt(99);
    }

    #[Test]
    public function TextConverter_GetHeader_ReturnsTheCorrectLine(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');

        $this->assertEquals('first', $textConverter->getHeader());
    }

    #[Test]
    public function TextConverter_GetHeader_IsEqualToGetLineAtZero(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');

        $this->assertEquals($textConverter->getLineAt(0), $textConverter->getHeader());
    }

    #[Test]
    public function TextConverter_Current_ReturnsTheFirstLine(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');
        $textConverter->rewind();

        $this->assertEquals('first', $textConverter->current());
    }

    #[Test]
    public function TextConverter_CurrentWithNext_ReturnsTheSecondLine(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');
        $textConverter->rewind();
        $textConverter->next();

        $this->assertEquals('second', $textConverter->current());
    }

    #[Test]
    public function TextConverter_CurrentWithNextAndPrevious_ReturnsTheFirstLine(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');
        $textConverter->rewind();
        $textConverter->next();
        $textConverter->previous();

        $this->assertEquals('first', $textConverter->current());
    }

    #[Test]
    public function TextConverter_CurrentWithRewind_ReturnsTheFirstLine(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');
        $textConverter->rewind();
        $textConverter->next();
        $textConverter->rewind();

        $this->assertEquals('first', $textConverter->current());
    }

    #[Test]
    public function TextConverter_MultipleNext_ThrowsOutOfBoundsException(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');

        $this->expectException(\OutOfBoundsException::class);

        $textConverter->rewind();
        $textConverter->next();
        $textConverter->next();
        $textConverter->next();
        $textConverter->next();
    }

    #[Test]
    public function TextConverter_MultiplePrevious_ThrowsOutOfBoundsException(): void {
        $textConverter = new TextConverter('first' . PHP_EOL . 'second');

        $this->expectException(\OutOfBoundsException::class);

        $textConverter->rewind();
        $textConverter->previous();
    }
}
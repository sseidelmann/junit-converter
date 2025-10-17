<?php
/**
 * @project Junit Converter
 * @file AbstractConverterTestCase.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverterTests\Converters;


use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Sseidelmann\JunitConverter\Converters\CsharpierConsole\Converter;

class AbstractConverterTest extends TestCase
{
    protected function loadAsset(string $asset): string {
        $filePath = dirname(__FILE__) . '/../assets/' . $asset;

        return file_get_contents($filePath);
    }


    #[Test]
    public function isCorrectName(): void {
        $csharpierConsoleConverter = new Converter(
            $this->loadAsset('csharpier.txt')
        );

        $this->assertEquals('csharpierconsole', $csharpierConsoleConverter->getName());
    }
}
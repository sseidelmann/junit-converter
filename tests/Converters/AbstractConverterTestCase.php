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


use PHPUnit\Framework\TestCase;

class AbstractConverterTestCase extends TestCase
{
    protected function loadAsset(string $asset): string {
        $filePath = dirname(__FILE__) . '/../assets/' . $asset;

        return file_get_contents($filePath);
    }
}
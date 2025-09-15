<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters\Traits;

trait JsonConverterTrait
{
    protected function isJson(string $input): bool {
        $checkFirstChar = $input[0] === '[' || $input[0] === '{';

        return $checkFirstChar;
    }
}

<?php

namespace Sseidelmann\JunitConverter\Converters\Traits;

trait JsonConverterTrait
{
    protected function isJson(string $input): bool {
        $checkFirstChar = $input[0] === '[' || $input[0] === '{';

        return $checkFirstChar;
    }
}
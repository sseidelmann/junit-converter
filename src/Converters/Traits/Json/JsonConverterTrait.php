<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters\Traits\Json;

/**
 * Trait for handling json formats.
 *
 */
trait JsonConverterTrait
{
    /**
     * Checks if the input is that type of JSON.
     *
     * @param string $input
     *
     * @return bool
     */
    public function isJson(string $input): bool {
        return $input[0] === '[' || $input[0] === '{';
    }
}

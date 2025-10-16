<?php
/**
 * @project Junit Converter
 * @file JsonConverterInterface.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters\Traits\Json;

/**
 * Interface for handling json formats.
 */
interface JsonConverterInterface
{
    /**
     * Checks if the input is that type of JSON.
     *
     * @param string $input
     *
     * @return bool
     */
    public function isJson(string $input): bool;
}
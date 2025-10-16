<?php
/**
 * @project Junit Converter
 * @file TextConverterTrait.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters\Traits\Text;

/**
 * Trait for handling text formats.
 */
trait TextConverterTrait
{
    /**
     * Loads the Text and returns the lines.
     *
     * @param string $input
     *
     * @return TextConverter
     */
    public function loadLines(string $input, string $lineSeparator): TextConverter {
        return new TextConverter($input, $lineSeparator);
    }
}
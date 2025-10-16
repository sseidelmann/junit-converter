<?php
/**
 * @project Junit Converter
 * @file TextConverterInterface.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters\Traits\Text;

interface TextConverterInterface
{
    /**
     * Loads the Text and returns the lines.
     *
     * @param string $input
     * @param string|null $lineSeparator
     *
     * @return TextConverter
     */
    public function loadLines(string $input, ?string $lineSeparator = null): TextConverter;
}
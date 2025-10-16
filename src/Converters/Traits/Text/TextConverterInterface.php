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
     *
     * @return array
     */
    public function loadLines(string $input): array
    {
        $dom = new DOMDocument();
        $dom->loadXML($input);

        return $dom;
    }
}
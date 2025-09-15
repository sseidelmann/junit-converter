<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters\Traits;

use DOMDocument;

trait XmlConverterTrait
{
    protected function isXml(string $input): bool {
        return $input[0] === '<?xml' || $input[0] === '<';
    }

    protected function loadXml(string $input): \DOMDocument {
        $dom = new DOMDocument();
        $dom->loadXML($input);

        return $dom;
    }
}

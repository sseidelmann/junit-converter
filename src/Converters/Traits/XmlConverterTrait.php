<?php

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
<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters\Traits\Xml;

use DOMDocument;

/**
 * Trait for handling xml formats.
 */
trait XmlConverterTrait
{
    /**
     * Checks if the input is that type of XML.
     *
     * @param string $input
     *
     * @return bool
     */
    public function isXml(string $input): bool {
        return $input[0] === '<?xml' || $input[0] === '<';
    }

    /**
     * Loads the XML and returns the DOMDocument.
     *
     * @param string $input
     *
     * @return DOMDocument
     */
    public function loadXml(string $input): DOMDocument
    {
        $dom = new DOMDocument();
        $dom->loadXML($input);

        return $dom;
    }
}

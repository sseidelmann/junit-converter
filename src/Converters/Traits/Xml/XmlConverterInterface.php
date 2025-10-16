<?php
/**
 * @project Junit Converter
 * @file XmlConverterInterface.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters\Traits\Xml;

use DOMDocument;

/**
 * Interface for handling xml formats.
 */
interface XmlConverterInterface
{
    /**
     * Checks if the input is that type of XML.
     *
     * @param string $input
     *
     * @return bool
     */
    public function isXml(string $input): bool;

    /**
     * Loads the XML and returns the DOMDocument.
     *
     * @param string $input
     *
     * @return DOMDocument
     */
    public function loadXml(string $input): DOMDocument;
}
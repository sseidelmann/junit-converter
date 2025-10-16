<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters;

use Sseidelmann\JunitConverter\Converters\Traits\Json\JsonConverterInterface;
use Sseidelmann\JunitConverter\Converters\Traits\Json\JsonConverterTrait;
use Sseidelmann\JunitConverter\Converters\Traits\Xml\XmlConverterInterface;
use Sseidelmann\JunitConverter\Converters\Traits\Xml\XmlConverterTrait;
use Sseidelmann\JunitConverter\JUnit\JUnit;

abstract class AbstractConverter implements ConverterInterface, JsonConverterInterface, XmlConverterInterface
{
    use JsonConverterTrait;
    use XmlConverterTrait;

    /**
     * Saves the input
     *
     * @var string
     */
    private string $input;

    /**
     * Default constructor.
     *
     * @param string $input the input string
     */
    public function __construct(string $input) {
        $this->input = $input;
    }

    /**
     * Returns the input.
     *
     * @return string
     */
    protected function getInput(): string {
        return $this->input;
    }

    /**
     * Creates a fresh instance of the junit.
     *
     * @return JUnit
     */
    protected function createJunit(): JUnit {
        return new JUnit();
    }
}

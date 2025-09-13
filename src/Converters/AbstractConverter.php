<?php
/**
 * @project Junit Converter
 * @file AbstractConverter.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters;

use Sseidelmann\JunitConverter\Converters\Traits\JsonConverterTrait;
use Sseidelmann\JunitConverter\Converters\Traits\XmlConverterTrait;
use Sseidelmann\JunitConverter\JUnit\JUnit;

class AbstractConverter
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
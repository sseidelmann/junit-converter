<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters;

use Sseidelmann\JunitConverter\JUnit\JUnit;

/**
 * Coverter Interface.
 */
interface ConverterInterface
{
    /**
     * Checks if the input is that type of report
     *
     * @return bool
     */
    public function isReport(): bool;

    /**
     * Converts the source to the JUnit format.
     *
     * @return JUnit
     */
    public function convert(): Junit;

    /**
     * Returns the name of the converter.
     *
     * @return string
     */
    public function getName(): string;
}

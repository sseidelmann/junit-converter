<?php

namespace Sseidelmann\JunitConverter\Converters;

use Sseidelmann\JunitConverter\JUnit\JUnit;

interface ConverterInterface
{
    /**
     * Checks if the input is that type of report
     *
     * @return bool
     */
    public function isReport(): bool;

    public function convert(): Junit;

    public function getName(): string;
}

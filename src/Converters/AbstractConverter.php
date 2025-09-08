<?php

namespace Sseidelmann\JunitConverter\Converters;

use Sseidelmann\JunitConverter\Converters\Traits\JsonConverterTrait;
use Sseidelmann\JunitConverter\Converters\Traits\XmlConverterTrait;

class AbstractConverter
{
    private string $input;

    public function __construct(string $input) {
        $this->input = $input;
    }

    protected function getInput(): string {
        return $this->input;
    }

    use JsonConverterTrait;
    use XmlConverterTrait;
}
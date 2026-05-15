<?php
/**
 * @project Junit Converter
 * @file CsharpierConsoleConverterHeader.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters\CsharpierConsole;

class CsharpierConsoleConverterHeader
{
    public string $fullLine;
    public string $severity;
    public string $file;
    public string $message;

    public ?int $line = null;

    public function __construct($line, $severity, $file, $message) {
        $this->fullLine = $line;
        $this->severity = $severity;
        $this->file = $file;
        $this->message = $message;
    }
}
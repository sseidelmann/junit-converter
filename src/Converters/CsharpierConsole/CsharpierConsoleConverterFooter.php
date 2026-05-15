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

/**
 * Converter for the footer.
 */
class CsharpierConsoleConverterFooter
{
    /**
     * Saves the number of checked files.
     *
     * @var int
     */
    private int $filesCount;

    /**
     * Saves the duration.
     *
     * @var string
     */
    private string $duration;

    /**
     * @param int $filesCount
     * @param string $duration
     */
    public function __construct(int $filesCount, string $duration)
    {
        $this->filesCount = $filesCount;
        $this->duration = $duration;
    }

    /**
     * Returns the number of checked files.
     *
     * @return int
     */
    public function getFilesCount(): int {
        return $this->filesCount;
    }

    /**
     * Returns the duration in seconds.
     *
     * @return float
     */
    public function getDurationInSeconds(): float {
        $matches = [];
        if (preg_match('/([\d]+)([^\d]+)/', $this->duration, $matches)) {
            switch ($matches[2]) {
                case 'ms': {
                    return (float) ($matches[1] / 1000);
                }
                case 's':
                default: {
                    return (float) $matches[1];
                }
            }
        }

        throw new \UnexpectedValueException("Unexpected duration format: {$this->duration}");
    }
}
<?php
/**
 * @project Junit Converter
 * @file TextConverter.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters\Traits\Text;

use OutOfBoundsException;

class TextConverter
{
    /**
     * Saves the lines.
     *
     * @var array|string[]
     */
    private array $lines;

    /**
     * Saves the position of the pointer.
     *
     * @var int
     */
    private int $position = 0;

    /**
     * Constructs the text converter.
     *
     * @param string $input
     * @param string $lineSeparator
     */
    public function __construct(string $input, string $lineSeparator = PHP_EOL) {
        $this->lines = explode($lineSeparator, $input);
    }

    /**
     * Returns the complete buffer of lines.
     *
     * @return string[]
     */
    public function getLines(): array {
        return $this->lines;
    }

    /**
     * Returns the line at position $position.
     *
     * @param int $position
     *
     * @throws OutOfBoundsException
     *
     * @return string
     */
    public function getLineAt(int $position): string {
        if (! $this->isValidIndex($position)) {
            throw new OutOfBoundsException();
        }
        return $this->lines[$position];
    }

    /**
     * Returns the header of the file.
     *
     * @return string
     */
    public function getHeader(): string {
        return $this->getLineAt(0);
    }

    /**
     * Moves the cursor to the next line.
     *
     * @throws OutOfBoundsException
     *
     * @return void
     */
    public function next(): void {
        $this->position++;

        if (! $this->valid()) {
            throw new OutOfBoundsException(sprintf('Index %s is out of bounds.', $this->position));
        }
    }

    /**
     * Moves the cursor to the previous line.
     *
     * @throws OutOfBoundsException
     *
     * @return void
     */
    public function previous(): void {
        $this->position--;

        if (! $this->valid()) {
            throw new OutOfBoundsException(sprintf('Index %s is out of bounds.', $this->position));
        }
    }

    /**
     * Returns the current line.
     *
     * @throws OutOfBoundsException
     *
     * @return string
     */
    public function current(): string {
        return $this->getLineAt($this->position);
    }

    /**
     * Rewinds the cursor to the first line.
     *
     * @return void
     */
    public function rewind(): void {
        $this->position = 0;
    }

    /**
     * Checks if the cursor is valid.
     *
     * @return bool
     */
    public function valid(): bool {
        return $this->isValidIndex($this->position);
    }

    /**
     * Checks if the index is valid.
     *
     * @param int $index
     *
     * @return bool
     */
    private function isValidIndex(int $index): bool {
        return $index >= 0 && $index < count($this->lines);
    }
}
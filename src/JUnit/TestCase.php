<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\JUnit;

class TestCase
{
    /**
     * Saves the name of the testcase.
     *
     * @var string
     */
    private string $name;

    /**
     * Saves the failures for the testcase.
     *
     * @var array
     */
    private array $failures = [];

    /**
     * Saves the line of the testcase.
     *
     * @var int
     */
    private int $line;

    /**
     * Default constructor.
     *
     * @param string $name the name of the testcase
     * @param int    $line the line of the testcase
     */
    public function __construct(string $name, int $line = 0) {
        $this->name = $name;
        $this->line = $line;
    }

    /**
     * Adds a failure to the testcase.
     *
     * @param Failure $failure the failure
     *
     * @return $this
     */
    public function addFailure(Failure $failure): TestCase {
        $this->failures[] = $failure;

        return $this;
    }

    /**
     * Returns the failures.
     *
     * @return array
     */
    public function getFailures(): array {
        return $this->failures;
    }

    /**
     * Converts the testcase to a domnode
     *
     * @param \DOMDocument $document
     *
     * @return \DOMNode
     *
     * @throws \DOMException
     */
    public function toXML(\DOMDocument $document): \DOMNode {
        $node = $document->createElement('testcase');
        $node->setAttribute('name', $this->name);

        if ($this->line != 0) {
            $node->setAttribute('line', (string) $this->line);
        }
        $node->setAttribute('failures', (string) count($this->failures));

        foreach ($this->failures as $failure) {
            $node->appendChild($failure->toXML($document));
        }

        return $node;
    }
}

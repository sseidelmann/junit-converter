<?php

/**
 * @project Junit Converter
 * @file TestSuite.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\JUnit;

class TestSuite
{
    /**
     * Saves the name of the suite
     *
     * @var string
     */
    private string $name;

    /**
     * Saves the test cases.
     *
     * @var array
     */
    private array $testCases = [];

    /**
     * Default constructor
     *
     * @param string $name
     */
    public function __construct(string $name) {
        $this->name = $name;
    }

    /**
     * Adds the test case.
     * @param TestCase $testCase
     * @return $this
     */
    private function addTestCase(TestCase $testCase): TestSuite {
        $this->testCases[] = $testCase;

        return $this;
    }

    /**
     * Creates the test case.
     *
     * @param string $name the name of the test case
     * @param int $line.   the line of the tests case
     *
     * @return TestCase
     */
    public function testCase(string $name, int $line = 0): TestCase {
        $testCase = new TestCase($name, $line);

        $this->addTestCase($testCase);

        return $testCase;
    }

    /**
     * Returns the failure count.
     *
     * @return int
     */
    public function getFailureCount(): int {
        $total = 0;

        foreach ($this->testCases as $testCase) {
            $total += count($testCase->getFailures());
        }

        return $total;
    }

    /**
     * Returns the xml representation of the suite.
     *
     * @param \DOMDocument $document The document
     *
     * @return \DOMNode
     *
     * @throws \DOMException
     */
    public function toXML(\DOMDocument $document): \DOMNode {
        $node = $document->createElement('testsuite');
        $node->setAttribute('name', $this->name);
        $node->setAttribute('failures', (string) $this->getFailureCount());

        foreach ($this->testCases as $testCase) {
            $node->appendChild($testCase->toXML($document));
        }

        return $node;
    }
}

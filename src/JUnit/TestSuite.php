<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

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
     * Saves the filename of the suite.
     *
     * @var string
     */
    private string $fileName;

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
        if ($this->hasFilename()) {
            $testCase->setFilename($this->getFilename());
        }

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
     * Sets the filename for the testcase.
     *
     * @param string $fileName
     *
     * @return $this
     */
    public function setFilename(string $fileName): TestSuite {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Returns the filename.
     *
     * @return string
     */
    public function getFilename(): string {
        return $this->fileName;
    }

    /**
     * Checks if a filename is configured.
     *
     * @return bool
     */
    public function hasFilename(): bool {
        return !empty($this->fileName);
    }


    /**
     * Returns the total count.
     *
     * @return int
     */
    public function getTestsCount(): int {
        return count($this->testCases);
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
        $testsCount = $this->getTestsCount();
        $failureCount = $this->getFailureCount();

        $node = $document->createElement('testsuite');
        $node->setAttribute('name', $this->name);
        $node->setAttribute('tests', (string) $testsCount);
        $node->setAttribute('failures', (string) $failureCount);
        $node->setAttribute('errors', '0');
        $node->setAttribute('skipped', '0');

        foreach ($this->testCases as $testCase) {
            $node->appendChild($testCase->toXML($document));
        }

        return $node;
    }
}

<?php
/**
 * @project Junit Converter
 * @file JUnit.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\JUnit;

/**
 * JUNIT Representation
 * @see https://github.com/testmoapp/junitxml
 */
class JUnit
{
    /**
     * Saves the test suites.
     *
     * @var TestSuite[]
     */
    private array $testSuites = [];

    /**
     * Adds the test suite.
     *
     * @param TestSuite $testSuite the name of the testsuite
     *
     * @return $this
     */
    private function addTestSuite(TestSuite $testSuite): JUnit
    {
        $this->testSuites[] = $testSuite;

        return $this;
    }

    /**
     * Creates a new test suite.
     *
     * @param string $name the name of the testsuite
     *
     * @return TestSuite
     */
    public function testSuite(string $name): TestSuite {
        $testSuite = new TestSuite($name);

        $this->addTestSuite($testSuite);

        return $testSuite;
    }

    /**
     * Checks if the testsuite has fauilures
     *
     * @return bool
     */
    public function hasFailures(): bool
    {
        foreach ($this->testSuites as $testSuite) {
            if ($testSuite->getFailureCount() > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Renders the XML.
     *
     * @return \DOMDocument
     *
     * @throws \DOMException
     */
    public function toXML(): \DOMDocument
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->formatOutput = true;

        $testSuites = $document->createElement('testsuites');
        $document->appendChild($testSuites);

        foreach ($this->testSuites as $testSuite) {
            $testSuites->appendChild($testSuite->toXML($document));
        }
        return $document;
    }

    /**
     * Returns the testsuites.
     *
     * @return TestSuite[]
     */
    public function getTestSuites(): array {
        return $this->testSuites;
    }

    /**
     * Renders the string representation of the JUnit file.
     *
     * @return string
     *
     * @throws \DOMException
     */
    public function __toString()
    {
        return $this->toXML()->saveXML();
    }
}
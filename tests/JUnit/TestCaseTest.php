<?php

/**
 * @project Junit Converter
 * @file TestCaseTest.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverterTests\JUnit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;

class TestCaseTest extends TestCase
{
    #[Test]
    public function itAddsTheFailuresCasesToTheStorage(): void {
        $junit = new JUnit();

        $testsuite = $junit->testSuite('my_testsuite');

        $testCase = $testsuite->testCase('my_testcase');

        $testCase->addFailure(new Failure('type', 'message'));

        $this->assertCount(1, $testCase->getFailures());
    }

    #[Test]
    public function toXmlCreateInstanceOfDomNode(): void {
        $junit = new JUnit();

        $testsuite = $junit->testSuite('my_testsuite');

        $testCase = $testsuite->testCase('my_testcase');

        $testCase->addFailure(new Failure('type', 'message'));

        $domDocument = new \DOMDocument();

        $xml = $testCase->toXML($domDocument);

        $this->assertInstanceOf(\DOMNode::class, $xml);
    }
}

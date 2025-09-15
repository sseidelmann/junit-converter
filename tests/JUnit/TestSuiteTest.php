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
use Sseidelmann\JunitConverter\JUnit\JUnit;

class TestSuiteTest extends TestCase
{
    #[Test]
    public function toXmlCreateInstanceOfDomNode(): void {
        $junit = new JUnit();

        $testsuite = $junit->testSuite('my_testsuite');

        $domDocument = new \DOMDocument();

        $xml = $testsuite->toXML($domDocument);

        $this->assertInstanceOf(\DOMNode::class, $xml);
    }
}

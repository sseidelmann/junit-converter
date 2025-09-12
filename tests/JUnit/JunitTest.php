<?php
/**
 * @project Junit Converter
 * @file JunitTests.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverterTests\JUnit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Sseidelmann\JunitConverter\JUnit\JUnit;

final class JunitTest extends TestCase
{
    #[Test]
    public function isInstanceOfJunit(): void {
        $junit = new JUnit();

        $this->assertInstanceOf(JUnit::class, $junit);
    }

    #[Test]
    public function createsXmlDocument(): void {
        $junit = new JUnit();

        $document = $junit->__toString();

        $this->assertStringStartsWith('<?xml', $document);
    }

    #[Test]
    public function hasZeroFailuresAtStart(): void {
        $junit = new JUnit();

        $this->assertFalse($junit->hasFailures());
    }

    #[Test]
    public function createsXmlDocumentOfInstanceDomDocument(): void {
        $junit = new JUnit();

        $this->assertInstanceOf(\DOMDocument::class, $junit->toXML());
    }

    #[Test]
    public function itAddsTheTestSuitesToTheStorage(): void {
        $junit = new JUnit();

        $junit->testSuite('new testsuite');

        $this->assertCount(1, $junit->getTestSuites());
    }
}
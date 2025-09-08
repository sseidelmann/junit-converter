<?php

namespace Sseidelmann\JunitConverter\Converters;

use DOMDocument;
use DOMElement;
use DOMXPath;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;
use Sseidelmann\JunitConverter\JUnit\TestCase;
use Sseidelmann\JunitConverter\JUnit\TestSuite;

class GnuConverter extends AbstractConverter implements ConverterInterface
{
    public function isReport(): bool
    {
        if (!$this->isJson($this->getInput()) && !$this->isXml($this->getInput())) {

        }

        return false;
    }

    public function convert(): Junit
    {
        $dom = $this->loadXml($this->getInput());

        $xpath = new DOMXPath($dom);
        $checkstyle = $xpath->query("//checkstyle")->item(0);

        $junit = new JUnit();

        $testSuite = new TestSuite("checkstyle");

        $files = $xpath->query('file', $checkstyle);
        /** @var DOMElement $file */
        foreach ($files as $file) {
            $fileName = $file->getAttribute('name');

            $testCase = new TestCase($fileName);

            $errors = $xpath->query('error', $file);
            print_r($errors);
            foreach ($errors as $error) {
                $line = $error->getAttribute('line');
                $column = $error->getAttribute('column');
                $severity = $error->getAttribute('severity');
                $message = $error->getAttribute('message');
                $source = $error->getAttribute('source');

                $testCase->addFailure(Failure::Warning(
                    $source,
                    sprintf(
                        '%1$s in %2$s on line %3$s column %4$s',
                        $message,
                        $fileName,
                        $line,
                        $column
                    )
                ));
            }

            $testSuite->addTestCase($testCase);
        }

        $junit->addTestSuite($testSuite);


        return $junit;
    }
}
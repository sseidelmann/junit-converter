<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters;

use DOMElement;
use DOMXPath;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;

class CheckstyleConverter extends AbstractConverter implements ConverterInterface
{
    public function getName(): string {
        return 'checkstyle';
    }

    public function isReport(): bool {
        if ($this->isXml($this->getInput())) {
            $dom = $this->loadXml($this->getInput());

            $xpath = new DOMXPath($dom);
            $item = $xpath->query("//checkstyle")->item(0);

            return $item !== null;
        }

        return false;
    }

    public function convert(): Junit {
        $dom = $this->loadXml($this->getInput());

        $xpath = new DOMXPath($dom);
        $checkstyle = $xpath->query("//checkstyle")->item(0);

        $junit = $this->createJunit();

        $files = $xpath->query('file', $checkstyle);

        /** @var DOMElement $file */
        foreach ($files as $file) {
            $fileName = $file->getAttribute('name');

            $testSuite = $junit->testSuite("checkstyle");
            $testSuite->setFilename($fileName);


            $errors = $xpath->query('error', $file);

            $errorsByLine = [];

            foreach ($errors as $error) {
                $source = $error->getAttribute('source');
                $errorsByLine[$source][] = $error;
            }

            foreach ($errorsByLine as $source => $errors) {
                foreach ($errors as $error) {
                    $line = $error->getAttribute('line');
                    $column = $error->getAttribute('column');
                    $severity = $error->getAttribute('severity');
                    $message = $error->getAttribute('message');

                    $testCase = $testSuite->testCase(sprintf('Rule %s', $source), $line);

                    $failure = new Failure();
                    $failure
                        ->withType(sprintf('%s (%s)', $message, $source))
                        ->withMessage(sprintf('%s, on line %s', $message, $line))
                        ->withDescription(sprintf('%s %s', strtoupper($severity), $message))
                    ;

                    $testCase->addFailure($failure);
                }
            }
        }

        return $junit;
    }
}

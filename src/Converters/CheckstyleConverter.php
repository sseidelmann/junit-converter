<?php
/**
 * @project Junit Converter
 * @file CheckstyleConverter.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters;

use DOMElement;
use DOMXPath;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;

class CheckstyleConverter extends AbstractConverter implements ConverterInterface
{
    public function getName(): string
    {
        return 'checkstyle';
    }

    public function isReport(): bool
    {
        if ($this->isXml($this->getInput())) {
            $dom = $this->loadXml($this->getInput());

            $xpath = new DOMXPath($dom);
            $item = $xpath->query("//checkstyle")->item(0);

            return $item !== null;
        }

        return false;
    }

    public function convert(): Junit
    {
        $dom = $this->loadXml($this->getInput());

        $xpath = new DOMXPath($dom);
        $checkstyle = $xpath->query("//checkstyle")->item(0);

        $junit = new JUnit();

        $testSuite = $junit->testSuite("checkstyle");

        $files = $xpath->query('file', $checkstyle);
        /** @var DOMElement $file */
        foreach ($files as $file) {
            $fileName = $file->getAttribute('name');

            $errors = $xpath->query('error', $file);

            $errorsByLine = [];
            foreach ($errors as $error) {
                $line = $error->getAttribute('line');
                $errorsByLine[$line][] = $error;
            }

            foreach ($errorsByLine as $line => $errors) {
                $testCase = $testSuite->testCase($fileName, $line);


                foreach ($errors as $error) {
                    $column = $error->getAttribute('column');
                    $severity = $error->getAttribute('severity');
                    $message = $error->getAttribute('message');
                    $source = $error->getAttribute('source');

                    $testCase->addFailure(Failure::Generic(
                        $severity,
                        $source,
                        sprintf(
                            '%1$s in %2$s on column %3$s',
                            $message,
                            $fileName,
                            $column
                        )
                    ));
            }
            }
        }

        return $junit;
    }
}
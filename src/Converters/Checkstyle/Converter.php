<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters\Checkstyle;

use DOMElement;
use DOMXPath;
use Sseidelmann\JunitConverter\Converters\AbstractConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;
use Sseidelmann\JunitConverter\Report\Issue;
use Sseidelmann\JunitConverter\Report\Report;
use Sseidelmann\JunitConverter\Report\Type;

class Converter extends AbstractConverter implements ConverterInterface
{
    const NAME = 'Checkstyle Report';

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

    public function convert(): Report
    {
        $dom = $this->loadXml($this->getInput());

        $xpath = new DOMXPath($dom);
        $checkstyle = $xpath->query("//checkstyle")->item(0);

        $report = $this->createReport(self::NAME, Type::Codelint);

        $files = $xpath->query('file', $checkstyle);

        /** @var DOMElement $file */
        foreach ($files as $file) {
            $fileName = $file->getAttribute('name');

            $errors = $xpath->query('error', $file);

            foreach ($errors as $error) {
                $reportIssue = $report->createIssue(function (Issue $reportIssue) use ($fileName, $error) {
                    $reportIssue
                        ->withType("Formatting")
                        ->withFile($fileName)
                        ->withMessage($error->getAttribute('message'))
                        ->withSeverity($error->getAttribute('severity'))
                        ->withDescription($error->getAttribute('message'))
                        ->withLine((int) $error->getAttribute('line'))
                        ->withColumn((int) $error->getAttribute('column'))
                    ;
                });

            }
        }

        return $report;
    }
}

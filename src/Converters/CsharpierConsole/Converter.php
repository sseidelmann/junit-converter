<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters\CsharpierConsole;

use Sseidelmann\JunitConverter\Converters\AbstractConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\Converters\Traits\Text\TextConverter;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;
use Sseidelmann\JunitConverter\Report\Issue;
use Sseidelmann\JunitConverter\Report\Report;
use Sseidelmann\JunitConverter\Report\Type;

/**
 * Converter for csharpier console output.
 */
class Converter extends AbstractConverter implements ConverterInterface
{
    const NAME = 'CSharpier Report';

    /**
     * Saves the lines.
     *
     * @var TextConverter
     */
    private TextConverter $lines;

    /** @inheritDoc */
    public function isReport(): bool {
        if (!$this->isXml($this->getInput()) && !$this->isJson($this->getInput())) {
            $this->lines = $this->loadLines($this->getInput());

            $header = $this->lines->getHeader();

            if (str_starts_with($header, 'Checked 0 files in')) {
                return $this->lines->count() == 1;
            }

            return null !== $this->matchHeader($header);
        }

        return false;
    }

    /** @inheritDoc */
    public function convert(): Report {
        $report = $this->createReport(self::NAME, Type::Codelint);

        $this->lines->rewind();

        $issueLines = [];
        $header = null;
        $lastHeader = null;

        do {
            $line = $this->lines->current();
            $tmpHeader = $this->matchHeader($line);
            $footer = $this->matchFooter($line);

            if ($tmpHeader) {
                $header = $tmpHeader;
                $lastHeader = $header;
            }

            if ($footer) {
                $report->getMetadata()
                    ->setCheckFilesCount($footer->getFilesCount())
                    ->setDurationInSeconds($footer->getDurationInSeconds())
                ;
            }

            if (!$tmpHeader && !$footer) {
                $issueLines[] = $line;
            }

            if (($tmpHeader || $footer) && count($issueLines) > 0) {
                $issue = $this->convertToIssue($lastHeader, $issueLines);
                $header = null;
                $issueLines = [];

                $report->createIssue(function (Issue $reportIssue) use ($issue) {
                    $reportIssue
                        ->withType("Formatting")
                        ->withFile($issue->header->file)
                        ->withMessage($issue->header->message)
                        ->withSeverity($issue->header->severity)
                        ->withDescription(implode(PHP_EOL, $issue->content))
                        ->withLine($issue->line)
                    ;
                });
            }
        } while ($this->lines->eof());

        return $report;
    }



    /**
     * Matches the footer.
     *
     * @param string $line
     *
     * @return CsharpierConsoleConverterFooter|null
     */
    private function matchFooter(string $line): ?CsharpierConsoleConverterFooter {
        $matches = [];
        if (preg_match('/Checked ([\d]+) files in (.*)\./', $line, $matches)) {
            return new CsharpierConsoleConverterFooter((int) $matches[1], $matches[2]);
        }

        return null;
    }

    private function matchHeader(string $line): ?CsharpierConsoleConverterHeader {
        $matches = [];
        if (preg_match('/([^\s]+)+\s([^\s]+)\s-\s(.+)/', $line, $matches)) {
            list($line, $severity, $file, $message) = $matches;
            if (in_array($severity, ['Error', 'Warning'])) {
                return new CsharpierConsoleConverterHeader(
                    $line,
                    $severity,
                    $file,
                    $message
                );
            }
        }

        return null;
    }

    /**
     * Converts the issue to the issue object.
     *
     * @param CsharpierConsoleConverterHeader $header
     * @param array $issueLines
     *
     * @return CsharpierConsoleConverterIssue
     */
    public function convertToIssue(CsharpierConsoleConverterHeader $header, array $issueLines): CsharpierConsoleConverterIssue
    {
        return new CsharpierConsoleConverterIssue($header, $issueLines);
    }
}

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

/**
 * Converter for csharpier console output.
 */
class Converter extends AbstractConverter implements ConverterInterface
{
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
    public function convert(): Junit {
        $junit = $this->createJunit();

        /** @var CsharpierConsoleConverterIssue[] $issues */
        $issues = [];

        while (false !== $this->lines->eof()) {
            $line = $this->lines->current();
            $tmpHeader = $this->matchHeader($line);

            if ($tmpHeader !== null) {
                $header = $tmpHeader;

                $tmpHeader = null;
                $issueLines = [];
                do {
                    $nextLine = $this->lines->getLineAt($this->lines->getPosition() + count($issueLines) + 1);
                    $tmpHeader = $this->matchHeader($nextLine);

                    if (null === $tmpHeader) {
                        $message = $nextLine;

                        if (preg_match('/\s\s(.+)/', $message, $matches)) {
                            $message = $matches[1];
                        }

                        if (preg_match('/\-+\sExpected\:\sAround\sLine\s([^\s]+)\s\-+/', $message, $matches)) {
                            $header->line = (int) $matches[1];
                        }

                        $issueLines[] = $message;
                    } else {
                        $issues[] = new CsharpierConsoleConverterIssue($header, $issueLines);
                    }
                } while ($tmpHeader === null && ($this->lines->getPosition() + count($issueLines) + 1) < count($this->lines));;
            }
        }

        $issuesByFile = [];
        foreach ($issues as $issue) {
            $issuesByFile[$issue->header->file][] = $issue;
        }

        $testSuite = $junit->testSuite("csharpier");
        foreach ($issuesByFile as $file => $issues) {
            foreach ($issues as $issue) {
                $failure = Failure::Generic(
                    $issue->header->severity,
                    $issue->header->message,
                    implode(PHP_EOL, $issue->content)
                );

                $message = $issue->header->message;
                $failure->withLine($issue->header->line);

                $testCase = $testSuite->testCase($message);
                $testCase->withClassname($file);
                $testCase->addFailure($failure);
            }
        }

        return $junit;
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
}

class CsharpierConsoleConverterIssue {

    public CsharpierConsoleConverterHeader $header;
    public array $content;

    public function __construct(CsharpierConsoleConverterHeader $header, array $content)
    {
        $this->header = $header;
        $this->content = $content;
    }
}

class CsharpierConsoleConverterHeader {
    public string $fullLine;
    public string $severity;
    public string $file;
    public string $message;

    public ?int $line = null;

    public function __construct($line, $severity, $file, $message) {
        $this->fullLine = $line;
        $this->severity = $severity;
        $this->file = $file;
        $this->message = $message;
    }
}

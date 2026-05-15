<?php
/**
 * @project Junit Converter
 * @file Report.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Report;

use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;

class Report
{
    private string $name;

    /** @var Issue[] */
    private array $issues = [];

    public ReportMetadata $metadata;

    private Type $type;

    /**
     * @param string $name
     */
    public function __construct(string $name, Type $type)
    {
        $this->name = $name;
        $this->metadata = new ReportMetadata();
        $this->type = $type;
    }

    public function createIssue(callable $issueCallable): Issue {
        $issue = new Issue();

        $issueCallable($issue);

        $this->issues[] = $issue;

        return $issue;
    }

    public function getIssues(): array {
        return $this->issues;
    }

    public function getIssueCount(): int {
        return count($this->issues);
    }

    /**
     * Returns the metadata of the report.
     *
     * @return ReportMetadata
     */
    public function getMetadata(): ReportMetadata {
        return $this->metadata;
    }

    private function getReportHeaderline() {
        $name = 'Report';
        switch ($this->type) {
            case Type::Codelint:
                $name = 'Code Formatting Report';
                break;
        }

        return $name;
    }

    public function toJunit(): JUnit {
        $junit = new JUnit();
        $junit->withName($this->getReportHeaderline());

        if ($this->metadata->checkedFilesCount) {
            $junit->withTestsCount($this->metadata->checkedFilesCount);
        }
        if ($this->metadata->durationInSeconds) {
            $junit->withDurationInSeconds($this->metadata->durationInSeconds);
        }

        // handle testsuite
        $testsuite = $junit->testSuite($this->name);

        if ($this->metadata->checkedFilesCount) {
            $testsuite->withTestsCount($this->metadata->checkedFilesCount);
        }
        if ($this->metadata->durationInSeconds) {
            $testsuite->withDurationInSeconds($this->metadata->durationInSeconds);
        }

        foreach ($this->issues as $issue) {
            $testCase = $testsuite->testCase($issue->file);

            $testCase
                ->withClassname($issue->type)
                ->withFilename($issue->file)
                ->withDurationInSeconds(0)
            ;

            $failure = Failure::Generic(
                $issue->severity,
                $issue->message,
                $issue->description
            );
            if ($issue->line) {
                $failure->withLine($issue->line);
            }

            $testCase->addFailure($failure);
        }

        return $junit;
    }
}
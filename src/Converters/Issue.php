<?php
/**
 * @project Junit Converter
 * @file SarifIssue.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters;

use Sseidelmann\JunitConverter\JUnit\Severity;

class Issue
{
    private string $ruleId;
    private string $message;

    private int $line;

    private int $column;

    private Severity $level;

    private function __construct(string $ruleId, string $message, int $line, int $column, Severity $level)
    {
        $this->ruleId = $ruleId;
        $this->message = $message;
        $this->line = $line;
        $this->column = $column;
        $this->level = $level;
    }

    protected static function getLevel(string $level): Severity
    {
        return match ($level) {
            'warning' => Severity::Warning,
            'error' => Severity::Error,
            default => Severity::Info,
        };
    }

    public static function create(string $ruleId, string $message, int $line, int $column, string $level): Issue
    {
        return new self(
            $ruleId,
            $message,
            $line,
            $column,
            static::getLevel($level)
        );
    }

    public function ruleId(): string
    {
        return $this->ruleId;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function line(): int
    {
        return $this->line;
    }

    public function column(): int
    {
        return $this->column;
    }

    public function level(): Severity
    {
        return $this->level;
    }
}
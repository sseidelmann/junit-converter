<?php
/**
 * @project Junit Converter
 * @file Issue.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Report;

class Issue
{
    public string $file;

    public string $message;

    public string $severity;

    public string $type;
    public string $description;

    public ?int $line;
    public ?int $column;

    public function withType(string $type): Issue {
        $this->type = $type;
        return $this;
    }

    public function withFile(string $file): Issue {
        $this->file = $file;
        return $this;
    }

    public function withMessage(string $message): Issue {
        $this->message = $message;
        return $this;
    }

    public function withSeverity(string $severity): Issue {
        $this->severity = $severity;
        return $this;
    }

    public function withDescription(string $description): Issue {
        $this->description = $description;
        return $this;
    }

    public function withLine(?int $line): Issue {
        $this->line = $line;
        return $this;
    }

    public function withColumn(?int $column): Issue {
        $this->column = $column;
        return $this;
    }
}
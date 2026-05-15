<?php
/**
 * @project Junit Converter
 * @file ReportMetadata.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Report;

class ReportMetadata
{
    public ?int $checkedFilesCount = null;

    public ?float $durationInSeconds = null;

    /**
     * Returns the number of checked files.
     *
     * @return int
     */
    public function getCheckFilesCount(): int {
        return $this->checkedFilesCount;
    }

    /**
     * Sets the number of checked files.
     *
     * @param int $checkedFilesCount
     *
     * @return ReportMetadata
     */
    public function setCheckFilesCount(int $checkedFilesCount): ReportMetadata {
        $this->checkedFilesCount = $checkedFilesCount;

        return $this;
    }

    /**
     * Returns the duration in seconds.
     *
     * @return float
     */
    public function getDurationInSeconds(): float {
        return $this->durationInSeconds;
    }

    /**
     * Sets the duration in seconds.
     *
     * @param float $durationInSeconds
     *
     * @return ReportMetadata
     */
    public function setDurationInSeconds(float $durationInSeconds): ReportMetadata {
        $this->durationInSeconds = $durationInSeconds;

        return $this;
    }
}
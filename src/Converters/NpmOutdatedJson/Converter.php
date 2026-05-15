<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters\NpmOutdatedJson;

use Sseidelmann\JunitConverter\Converters\AbstractConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;
use Sseidelmann\JunitConverter\Report\Report;
use Sseidelmann\JunitConverter\Report\Type;

/**
 * Converter for handling outdated npm packages.
 */
class Converter extends AbstractConverter implements ConverterInterface
{
    const NAME = 'NPM Outdated Packages Report';

    /**
     * Saves the converted data.
     *
     * @var array
     */
    private array $data;

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName(): string {
        return 'npm_outdated';
    }

    public function isReport(): bool {
        if ($this->isJson($this->getInput())) {
            $this->data = json_decode($this->getInput(), true);

            foreach ($this->data as $outdatedInformation) {
                if (! isset($outdatedInformation['wanted']) ||
                    ! isset($outdatedInformation['latest']) ||
                    ! isset($outdatedInformation['dependent'])) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    public function convert(): Report {
        $report = $this->createReport(self::NAME, Type::Codelint);

        foreach ($this->data as $package => $outdatedInformation) {
            if ($outdatedInformation['wanted'] != $outdatedInformation['latest']) {
                $reportIssue = $report->createIssue();

                $reportIssue
                    ->withType("Formatting")
                    ->withFile('package.json')
                    ->withMessage($package)
                    ->withSeverity('Failure')
                    ->withDescription(sprintf(
                        'from "%1$s" to "%2$s"',
                        $outdatedInformation['wanted'],
                        $outdatedInformation['latest']
                    ))
                ;
            }
        }

        return $report;
    }
}

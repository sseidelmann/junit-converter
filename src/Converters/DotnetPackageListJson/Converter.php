<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters\DotnetPackageListJson;

use Sseidelmann\JunitConverter\Converters\AbstractConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;
use Sseidelmann\JunitConverter\Report\Report;
use Sseidelmann\JunitConverter\Report\Type;

/**
 * Converter for handling dotnet packages.
 */
class Converter extends AbstractConverter implements ConverterInterface
{
    const NAME = 'Dotnet Packagelist Report';

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

    /**
     * Checks if the report is valid.
     *
     * @return bool
     */
    public function isReport(): bool {
        if ($this->isJson($this->getInput())) {
            $this->data = json_decode($this->getInput(), true);

            return isset($this->data['version']) &&
                isset($this->data['parameters']) &&
                isset($this->data['sources']) &&
                isset($this->data['projects']);
        }

        return false;
    }

    /**
     * Converts the dotnet package output to junit format
     *
     * @return Report
     */
    public function convert(): Report {
        $report = $this->createReport(self::NAME, Type::Codelint);

        $type = 'unknown';

        switch ($this->data['parameters']) {
            case '--outdated': $type = 'outdated';
                break;
            case '--vulnerable': $type = 'vulnerable';
                break;
        }

        foreach ($this->data['projects'] as $project) {
            foreach ($project['frameworks'] as $framework) {
                foreach ($framework['topLevelPackages'] as $topLevelPackage) {
                    if ($topLevelPackage['requestedVersion'] != $topLevelPackage['latestVersion']) {
                        $reportIssue = $report->createIssue();

                        $reportIssue
                            ->withType("Deprecated Packages")
                            ->withFile($project['path'])
                            ->withMessage($topLevelPackage['id'])
                            ->withSeverity($type)
                            ->withDescription(sprintf(
                                'from "%1$s" to "%2$s"',
                                $topLevelPackage['requestedVersion'],
                                $topLevelPackage['latestVersion']
                            ))
                        ;
                    }
                }
            }
        }

        return $report;
    }
}

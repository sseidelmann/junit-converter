<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters;

use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;

/**
 * Converter for handling dotnet packages.
 */
class DotnetPackageListJsonConverter extends AbstractConverter implements ConverterInterface
{
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
     * @return JUnit
     */
    public function convert(): Junit {
        $junit = $this->createJunit();

        $testSuite = $junit->testSuite("dotnet_packages");

        $type = 'unknown';

        switch ($this->data['parameters']) {
            case '--outdated': $type = 'outdated';
                break;
            case '--vulnerable': $type = 'vulnerable';
                break;
        }

        foreach ($this->data['projects'] as $project) {
            $testCase = $testSuite->testCase($project['path']);

            foreach ($project['frameworks'] as $framework) {
                foreach ($framework['topLevelPackages'] as $topLevelPackage) {
                    if ($topLevelPackage['requestedVersion'] != $topLevelPackage['latestVersion']) {
                        $testCase->addFailure(Failure::Generic(
                            $type,
                            $topLevelPackage['id'],
                            sprintf(
                                'from "%1$s" to "%2$s"',
                                $topLevelPackage['requestedVersion'],
                                $topLevelPackage['latestVersion']
                            )
                        ));
                    }
                }
            }
        }

        return $junit;
    }
}

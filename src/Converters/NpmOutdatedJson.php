<?php
/**
 * @project Junit Converter
 * @file NpmOutdatedJson.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);


namespace Sseidelmann\JunitConverter\Converters;

use DOMDocument;
use DOMElement;
use DOMXPath;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;
use Sseidelmann\JunitConverter\JUnit\TestCase;
use Sseidelmann\JunitConverter\JUnit\TestSuite;

class NpmOutdatedJson extends AbstractConverter implements ConverterInterface
{
    private array $data;

    public function getName(): string
    {
        return 'npm_outdated';
    }


    public function isReport(): bool
    {
        if ($this->isJson($this->getInput())) {
            $this->data = json_decode($this->getInput(), true);

            foreach ($this->data as $outdatedInformation) {
                if (!isset($outdatedInformation['wanted']) ||
                    !isset($outdatedInformation['latest']) ||
                    !isset($outdatedInformation['dependent'])) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    public function convert(): Junit
    {
        $junit = new JUnit();

        $testSuite = $junit->testSuite("npm_outdated");

        $testCase = $testSuite->testCase('package.json');
        foreach ($this->data as $package => $outdatedInformation) {
            if ($outdatedInformation['wanted'] != $outdatedInformation['latest']) {
                $testCase->addFailure(Failure::Warning(
                    $package,
                    sprintf(
                        'from "%1$s" to "%2$s"',
                        $outdatedInformation['wanted'],
                        $outdatedInformation['latest']
                    )
                ));
            }
        }

        return $junit;
    }
}
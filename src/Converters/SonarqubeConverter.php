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

class SonarqubeConverter extends AbstractConverter implements ConverterInterface
{
    public function getName(): string {
        return 'sonarqube';
    }

    private array $data = [];

    public function isReport(): bool {
        if ($this->isJson($this->getInput())) {
            $this->data = json_decode($this->getInput(), true);

            return isset($this->data['issues']) && isset($this->data['issues'][0]['engineId']);
        }

        return false;
    }

    public function convert(): Junit {
        $junit = new JUnit();
        $testSuite = $junit->testSuite('sonarqube');

        foreach ($this->data['issues'] as $issue) {
            $engineId = $issue['engineId'];
            $primaryLocation = $issue['primaryLocation'];
            $ruleId = $issue['ruleId'];
            $severity = $issue['severity'];
            $type = $issue['type'];

            $filePath = $primaryLocation['filePath'];
            $message = $primaryLocation['message'];
            $textRange = $primaryLocation['textRange'];


            $testCase = $testSuite->testCase($filePath);

            $testCase->addFailure(Failure::Generic(
                $severity,
                $message,
                sprintf(
                    '%1$s in %2$s on line %3$s column %4$s (%5$s)',
                    $message,
                    $filePath,
                    $textRange['startLine'],
                    $textRange['startColumn'],
                    $ruleId
                )
            ));
        }

        return $junit;
    }
}

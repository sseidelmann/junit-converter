<?php
/**
 * @project Junit Converter
 * @file Converter.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters\Sarif;

use Sseidelmann\JunitConverter\Converters\AbstractConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\Converters\Issue;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;

class Converter extends AbstractConverter implements ConverterInterface
{
    /**
     * Saves the converted data.
     *
     * @var array
     */
    private array $data;

    /**
     * Checks if the report is valid.
     *
     * @return bool
     */
    public function isReport(): bool {
        if ($this->isJson($this->getInput())) {
            $this->data = json_decode($this->getInput(), true);

            return
                isset($this->data['$schema']) &&
                $this->data['$schema'] == 'http://json.schemastore.org/sarif-1.0.0'
            ;
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

        $issuesByFile = [];
        foreach ($this->data['runs'] as $run) {
            foreach ($run['results'] as $result) {
                foreach ($result['locations'] as $location) {
                    $file = str_replace('file://', '', $location['resultFile']['uri']);
                    $issuesByFile[$file][] = Issue::create(
                        $result['ruleId'],
                        $result['message'],
                        $location['resultFile']['region']['startLine'],
                        $location['resultFile']['region']['startColumn'],
                        $result['level'],
                    );
                }
            }
        }

        $testSuite = $junit->testSuite($this->getName());

        foreach ($issuesByFile as $file => $issues) {
            /* @var Issue[] $issues */
            foreach ($issues as $issue) {
                $testSuite->addIssue($file, $issue);
            }
        }

        return $junit;
    }
}
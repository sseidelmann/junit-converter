<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters;

use DOMElement;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;

class GnuConverter extends AbstractConverter implements ConverterInterface
{
    private array $matches;

    public function getName(): string {
        return 'gnu';
    }

    public function isReport(): bool {
        if (! $this->isJson($this->getInput()) && ! $this->isXml($this->getInput())) {
            // <Tool>:<Datei>:<Zeile>:<Regel-ID> <Schwere>:<Beschreibung>
            $this->matches = [];
            preg_match_all("/(?<tool>[^\:]+)\:(?<file>[^\:]+)\:(?<line>[^\:]+)\:\s?(?<rule>[^\s]+)\s(?<severity>[^\:]+)\:\s?(?<message>.+)/m", $this->getInput(), $this->matches);

            return count($this->matches[0]) > 0;
        }

        return false;
    }

    public function convert(): Junit {
        $junit = new JUnit();

        $testSuite = $junit->testSuite("gnu");

        $fileMatches = [];

        foreach ($this->matches['file'] as $cnt => $file) {
            $fileMatches[$file][] = [
                'tool' => trim($this->matches['tool'][$cnt]),
                'line' => trim($this->matches['line'][$cnt]),
                'rule' => trim($this->matches['rule'][$cnt]),
                'severity' => trim($this->matches['severity'][$cnt]),
                'message' => trim($this->matches['message'][$cnt]),
            ];
        }

        /** @var DOMElement $file */
        foreach ($fileMatches as $file => $matches) {
            $testCase = $testSuite->testCase($file);

            foreach ($matches as $match) {
                $testCase->addFailure(Failure::Generic(
                    $match['severity'],
                    $match['rule'],
                    sprintf(
                        '%1$s in %2$s on line %3$s',
                        $match['message'],
                        $file,
                        $match['line']
                    )
                ));
            }
        }


        return $junit;
    }
}

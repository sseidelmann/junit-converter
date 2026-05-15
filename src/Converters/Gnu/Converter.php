<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Converters\Gnu;

use DOMElement;
use Sseidelmann\JunitConverter\Converters\AbstractConverter;
use Sseidelmann\JunitConverter\Converters\ConverterInterface;
use Sseidelmann\JunitConverter\JUnit\Failure;
use Sseidelmann\JunitConverter\JUnit\JUnit;
use Sseidelmann\JunitConverter\Report\Report;
use Sseidelmann\JunitConverter\Report\Type;

class Converter extends AbstractConverter implements ConverterInterface
{
    const NAME = 'GNU Report';

    private array $matches;

    public function getName(): string {
        return 'gnu';
    }

    public function isReport(): bool {
        if (! $this->isJson($this->getInput()) && ! $this->isXml($this->getInput())) {
            // <Tool>:<Datei>:<Zeile>:<Regel-ID> <Schwere>:<Beschreibung>
            $this->matches = [];
            $pattern = "(?<tool>[^\:]+)\:(?<file>[^\:]+)\:(?<line>[^\:]+)\:\s?(?<rule>[^\s]+)\s(?<severity>[^\:]+)\:\s?(?<message>.+)";
            $lines = explode(PHP_EOL, $this->getInput());
            if (preg_match(sprintf("/%s/", $pattern), $lines[0])) {
                preg_match_all(sprintf("/%s/m",$pattern), $this->getInput(), $this->matches);

                return count($this->matches[0]) > 0;
            }

        }

        return false;
    }

    public function convert(): Report {
        $report = $this->createReport(self::NAME, Type::Codelint);

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
            foreach ($matches as $match) {
                $reportIssue = $report->createIssue();

                $reportIssue
                    ->withType("GNU Formatting")
                    ->withFile($file)
                    ->withMessage($match['rule'])
                    ->withSeverity($match['severity'])
                    ->withDescription($match['message'])
                    ->withLine((int) $match['line'])
                ;
            }
        }


        return $report;
    }
}

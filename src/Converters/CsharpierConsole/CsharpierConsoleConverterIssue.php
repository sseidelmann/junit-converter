<?php
/**
 * @project Junit Converter
 * @file CsharpierConsoleConverterIssue.php
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

declare(strict_types=1);

namespace Sseidelmann\JunitConverter\Converters\CsharpierConsole;

class CsharpierConsoleConverterIssue
{

    public CsharpierConsoleConverterHeader $header;
    public array $content;

    public ?int $line = null;

    public function __construct(CsharpierConsoleConverterHeader $header, array $content)
    {
        $this->header = $header;
        $this->content = $content;

        $this->parse();
    }

    private function parse() {
        $matches = [];
        $actual = [];
        $expected = [];
        $isActual = false;
        if (preg_match('/[\-]+\sExpected: Around Line (\d+)\s[\-]+/', $this->content[0], $matches)) {
            $this->line = (int) $matches[1];
            for ($i = 1; $i < count($this->content); $i++) {
                if (preg_match('/[\-]+\sActual: Around Line (\d+)\s[\-]+/', $this->content[$i], $matches)) {
                    $isActual = true;
                } else {

                    if ($isActual) {
                        $actual[] = $this->content[$i];
                    } else {
                        $expected[] = $this->content[$i];
                    }
                }
            }

            $this->content = array_merge(
                ['Expected:'],
                $expected,
                ['Actual:'],
                $actual
            );
        }
    }
}
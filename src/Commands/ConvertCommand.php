<?php

declare(strict_types=1);

/*
 * @project Junit Converter
 * @author Sebastian Seidelmann
 * @copyright 2025 Sebastian Seidelmann
 * @license MIT
 */

namespace Sseidelmann\JunitConverter\Commands;

use Sseidelmann\JunitConverter\Factories\ConverterFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for converting the input to junit xml.
 */
class ConvertCommand extends Command
{
    /**
     * Saves the converter
     *
     * @var ConverterFactory
     */
    private ConverterFactory $converterFactory;

    /**
     * Default constructor.
     *
     * @param ConverterFactory $converterFactory
     */
    public function __construct(ConverterFactory $converterFactory) {
        parent::__construct();

        $this->converterFactory = $converterFactory;
    }

    /**
     * @inheritDoc
     */
    protected function configure() {
        $this
            ->setName('convert')
            ->setDescription(
                'Convert the output to JUnit XML.'
            )
            ->addArgument(
                'input',
                InputArgument::OPTIONAL,
                "The report to convert from"
            );
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int {
        $report = $this->readStdIn();

        if (strlen($report) === 0) {
            $report = (string) $input->getArgument('input');
        }


        if (strlen($report) === 0) {
            $output->writeln("no input");

            return 1;
        }

        $converter = $this->converterFactory->guessConverter($report);

        $junit = $converter->convert();

        $output->write((string) $junit);

        return 0;
    }

    /**
     * Reads the stdin.
     *
     * @return string
     */
    private function readStdIn(): string {
        $stdin = stream_get_contents(STDIN);

        return $stdin;
    }
}

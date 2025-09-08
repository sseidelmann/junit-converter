<?php

namespace Sseidelmann\JunitConverter\Commands;

use Sseidelmann\JunitConverter\Factories\ConverterFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertCommand extends Command
{

    /**
     * Saves the converter
     * @var ConverterFactory
     */
    private ConverterFactory $converterFactory;

    public function __construct(ConverterFactory $converterFactory)
    {
        parent::__construct();

        $this->converterFactory = $converterFactory;
    }

    protected function configure()
    {
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


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $report = $this->readStdIn();

        if (strlen($report) === 0) {
            $report = (string) $input->getArgument('input');
        }


        if (strlen($report) === 0) {
            echo "no input";
            return 1;
        }

        $converter = $this->converterFactory->guessConverter($report);


        $junit = $converter->convert($report);


        $output->write((string) $junit);

        return 0;
    }

    private function readStdIn(): string{
        // Read from stdin
        $stdin = stream_get_contents(STDIN);

        return $stdin;
    }
}
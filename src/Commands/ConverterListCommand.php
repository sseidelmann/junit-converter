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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConverterListCommand extends Command
{
    /**
     * Saves the converter
     * @var ConverterFactory
     */
    private ConverterFactory $converterFactory;

    public function __construct(ConverterFactory $converterFactory) {
        parent::__construct();

        $this->converterFactory = $converterFactory;
    }

    protected function configure() {
        $this
            ->setName('convert:list')
            ->setDescription(
                'Lists the converter'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $converters = $this->converterFactory->getConverter();

        foreach ($converters as $converter) {
            $output->writeln($converter->getName());
        }

        return 0;
    }
}

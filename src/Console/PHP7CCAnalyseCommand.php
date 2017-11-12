<?php


namespace cwreden\php7ccAnalyser\Console;


use cwreden\php7ccAnalyser\Parser;
use cwreden\php7ccAnalyser\ScanAnalyserTest;
use cwreden\php7ccAnalyser\ScannedFile;
use cwreden\php7ccAnalyser\ScanResultFile;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PHP7CCAnalyseCommand extends Command
{
    const COMMAND_NAME = 'php7ccAnalyse';
    const PATH_ARGUMENT_NAME = 'path';
    const LIST_OPTION_NAME = 'list';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME)
            ->addArgument(
                static::PATH_ARGUMENT_NAME,
                InputArgument::REQUIRED,
                'The json file from php7cc scan.'
            )
            ->addOption(
                static::LIST_OPTION_NAME,
                'l',
                InputOption::VALUE_NONE,
                'Show all matched compatibility errors.'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument(static::PATH_ARGUMENT_NAME);
        $showList = $input->getOption(static::LIST_OPTION_NAME);

        $parser = new Parser();
        $scan = $parser->parse(new ScanResultFile($path));

        $totalErrors = $scan->getTotalErrors();
        $totalWarnings = $scan->getTotalWarnings();

        if ($showList) {
            $scannedFileCollection = $scan->getScannedFileCollection();
            /** @var ScannedFile $scannedFile */
            foreach ($scannedFileCollection as $scannedFile) {
                $output->writeln(PHP_EOL . $scannedFile->getPath());
                $output->writeln('==================================================');
                foreach ($scannedFile->getErrors() as $error) {
                    $output->writeln(sprintf(
                        'Line: %d => %s',
                        $error['line'],
                        $error['text']
                    ));
                }
                foreach ($scannedFile->getWarnings() as $warning) {
                    $output->writeln(sprintf(
                        'Line: %d => %s',
                        $warning['line'],
                        $warning['text']
                    ));
                }
            }
        }

        $output->writeln(sprintf(
            PHP_EOL . PHP_EOL . '[Checked files: %d, Effected files: %d, Warnings: %d, Errors: %d]' . PHP_EOL,
            $scan->getSummary()->getCheckedFiles(),
            $scan->getTotalEffectedFiles(),
            $totalWarnings,
            $totalErrors
        ));

        if ($totalErrors > 0) {
            $output->writeln('There are php 7 incompatible statements!');
            return 2;
        } elseif ($totalWarnings > 0) {
            $output->writeln('There are php 7 risky statements!');
            return 1;
        } else {
            $output->writeln('There are no php 7 compatibility errors or warnings.');
            return 0;
        }
    }

}
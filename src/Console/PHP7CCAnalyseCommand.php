<?php


namespace cwreden\php7ccAnalyser\Console;


use cwreden\php7ccAnalyser\Analyser;
use cwreden\php7ccAnalyser\FilePersistenceAdapter;
use cwreden\php7ccAnalyser\Parser;
use cwreden\php7ccAnalyser\ScannedSourceFile;
use cwreden\php7ccAnalyser\ScanResultFile;
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
    const PREVIEW_OPTION_NAME = 'preview';
    const IGNORE_FIRST_RESULT_OPTION_NAME = 'ignore-first';

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
                'Show all matched compatibility issues.'
            )
            ->addOption(
                static::PREVIEW_OPTION_NAME,
                '',
                InputOption::VALUE_NONE,
                'Preview mode does not save the scan for upcoming analyses'
            )
            ->addOption(
                static::IGNORE_FIRST_RESULT_OPTION_NAME,
                '',
                InputOption::VALUE_NONE,
                'The analyse will not fail without a previous scan.'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument(static::PATH_ARGUMENT_NAME);
        $showList = $input->getOption(static::LIST_OPTION_NAME);
        $preview = $input->getOption(static::PREVIEW_OPTION_NAME);
        $ignoreFirstResult = $input->getOption(static::IGNORE_FIRST_RESULT_OPTION_NAME);

        $cachePath = '.' . DIRECTORY_SEPARATOR . 'lastScan';
        $analyser = new Analyser(
            $output,
            new FilePersistenceAdapter($cachePath)
        );
        $analyseResult = $analyser->analyse(new ScanResultFile($path), !$preview, $showList);

        $output->writeln(PHP_EOL);
        if ($analyseResult === Analyser::RESULT_STATUS_FAILURES) {
            $output->writeln('There are new php 7 incompatible statements!');
        } elseif ($analyseResult === Analyser::RESULT_STATUS_RISKY) {
            $output->writeln('There are new php 7 risky statements!');
        } else {
            $output->writeln('There are no new php 7 compatibility errors or warnings.');
        }

        if (!$ignoreFirstResult && $analyseResult === Analyser::RESULT_STATUS_FAILURES) {
            return 2;
        } elseif (!$ignoreFirstResult && $analyseResult === Analyser::RESULT_STATUS_RISKY) {
            return 1;
        }
        return 0;
    }

}
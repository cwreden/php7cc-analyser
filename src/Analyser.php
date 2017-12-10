<?php

namespace cwreden\php7ccAnalyser;


use Symfony\Component\Console\Output\OutputInterface;

class Analyser
{
    const RESULT_STATUS_OK = 'OK';
    const RESULT_STATUS_RISKY = 'RISKY';
    const RESULT_STATUS_FAILURES = 'FAILURES';
    /**
     * @var PersistenceAdapterInterface
     */
    private $persistenceAdapter;
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * Analyser constructor.
     * @param OutputInterface $output
     * @param PersistenceAdapterInterface $persistenceAdapter
     */
    public function __construct(
        OutputInterface $output,
        PersistenceAdapterInterface $persistenceAdapter
    )
    {
        $this->persistenceAdapter = $persistenceAdapter;
        $this->output = $output;
    }

    /**
     * @param ScanResultFile $scanResultFile
     * @param bool $persist
     * @param bool $showList
     * @return string
     */
    public function analyse(ScanResultFile $scanResultFile, $persist = true, $showList = false)
    {
        $parser = new Parser();

        $this->output->write('Load previous scan result');
        try {
            $previousScan = $this->persistenceAdapter->getLast();
            $previousTotalIssueMap = $this->getTotalIssueMap($previousScan);

            $this->output->writeln(' ...done');
        } catch (NoPreviousScanFoundException $exception) {
            $previousScan = null;
            $previousTotalIssueMap = null;

            $this->output->writeln(' ...failed');
            $this->output->writeln('>> No previous scan result found.' . PHP_EOL);
        }

        $this->output->write('Parse actual scan result');

        $scan = $parser->parse($scanResultFile);
        $totalIssueMap = $this->getTotalIssueMap($scan);

        $this->output->writeln(' ...done');


        $newWarningCount = 0;
        $newErrorCount = 0;
        $newEffectedFiles = new AnalyserEffectedFilesResult();

        foreach ($totalIssueMap->getWarningMap() as $key => $total) {
            if ($total === 0) {
                continue;
            }

            if ($previousTotalIssueMap instanceof TotalIssueMap) {
                $previousTotal = $previousTotalIssueMap->getWarningCounter($key);
                if ($total > $previousTotal) {
                    $newWarningCount += ($total - $previousTotal);
                    $newEffectedFiles->addIfNotAlready($key);
                }
            } else {
                $newWarningCount += $total;
                $newEffectedFiles->addIfNotAlready($key);
            }
        }

        foreach ($totalIssueMap->getErrorMap() as $key => $total) {
            if ($total === 0) {
                continue;
            }

            if ($previousTotalIssueMap instanceof TotalIssueMap) {
                $previousTotal = $previousTotalIssueMap->getErrorCounter($key);
                if ($total > $previousTotal) {
                    $newErrorCount += ($total - $previousTotal);
                    $newEffectedFiles->addIfNotAlready($key);
                }
            } else {
                $newErrorCount += $total;
                $newEffectedFiles->addIfNotAlready($key);

            }
        }


        if ($showList) {
            $this->showCompleteIssueList($scan);
        }


        $status = self::RESULT_STATUS_OK;
        if ($newErrorCount > 0) {
            $status = self::RESULT_STATUS_FAILURES;
        } elseif ($newWarningCount > 0) {
            $status = self::RESULT_STATUS_RISKY;
        }


        $this->showAnalyseSummary($status, $scan, $newEffectedFiles, $newWarningCount, $newErrorCount);


        if ($persist) {
            $this->output->writeln('Persist scan result as new previous.');
            $this->persistenceAdapter->persist($scan);
        }

        return $status;
    }

    /**
     * @param Scan $scan
     * @return TotalIssueMap
     */
    private function getTotalIssueMap(Scan $scan)
    {

        $warningMap = [];
        $errorMap = [];

        /** @var ScannedSourceFile $scannedSourceFile */
        foreach ($scan->getScannedFileCollection() as $scannedSourceFile) {
            $sourceName = $scannedSourceFile->getPath();
            $warningMap[$sourceName] = $scannedSourceFile->getTotalWarnings();
            $errorMap[$sourceName] = $scannedSourceFile->getTotalErrors();
        }

        return new TotalIssueMap($warningMap, $errorMap);
    }

    /**
     * @param $scan
     */
    public function showCompleteIssueList($scan): void
    {
        $this->output->writeln(PHP_EOL);
        $this->output->writeln('All found php 7 incompatibilities:');

        $scannedFileCollection = $scan->getScannedFileCollection();
        /** @var ScannedSourceFile $scannedFile */
        foreach ($scannedFileCollection as $scannedFile) {
            $this->output->write(PHP_EOL . '### ');
            $this->output->writeln($scannedFile->getPath());

            if ($scannedFile->getTotalWarnings() > 0) {
                $this->output->writeln('> Warnings:');
                /** @var Issue $warning */
                foreach ($scannedFile->getWarnings() as $warning) {
                    $this->output->writeln(sprintf(
                        '>> Line: %d => %s',
                        $warning->getLine(),
                        $warning->getText()
                    ));
                }
            }

            if ($scannedFile->getTotalErrors()) {
                $this->output->writeln('> Errors:');
                /** @var Issue $error */
                foreach ($scannedFile->getErrors() as $error) {
                    $this->output->writeln(sprintf(
                        '>> Line: %d => %s',
                        $error->getLine(),
                        $error->getLine()
                    ));
                }
            }
        }
    }

    /**
     * @param string $status
     * @param Scan $scan
     * @param AnalyserEffectedFilesResult $newEffectedFiles
     * @param int $newWarningCount
     * @param int $newErrorCount
     */
    public function showAnalyseSummary(
        string $status,
        Scan $scan,
        AnalyserEffectedFilesResult $newEffectedFiles,
        int $newWarningCount,
        int $newErrorCount): void
    {
        $this->output->writeln(PHP_EOL);
        $this->output->writeln($status);
        $this->output->writeln(sprintf(
            '[Checked files: %d, Effected files: %d(%d), Warnings: %d(%d), Errors: %d(%d)]',
            $scan->getSummary()->getCheckedFiles(),
            $newEffectedFiles->getTotal(),
            $scan->getTotalEffectedFiles(),
            $newWarningCount,
            $scan->getTotalWarnings(),
            $newErrorCount,
            $scan->getTotalErrors()
        ));
    }
}
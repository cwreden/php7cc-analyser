<?php

namespace cwreden\php7ccAnalyser;


class Analyser
{
    /**
     * @var PersistenceAdapterInterface
     */
    private $persistenceAdapter;

    /**
     * Analyser constructor.
     * @param PersistenceAdapterInterface $persistenceAdapter
     */
    public function __construct(PersistenceAdapterInterface $persistenceAdapter)
    {
        $this->persistenceAdapter = $persistenceAdapter;
    }

    /**
     * @param ScanResultFile $scanResultFile
     * @param bool $persist
     * @return AnalyseResult
     */
    public function analyse(ScanResultFile $scanResultFile, $persist = true)
    {
        $parser = new Parser();
        $scan = $parser->parse($scanResultFile);

        try {
            $previousScan = $this->persistenceAdapter->getLast();
            $previousTotalIssueMap = $this->getTotalIssueMap($previousScan);
        } catch (NoPreviousScanFoundException $exception) {
            $previousScan = null;
            $previousTotalIssueMap = null;
        }


        $totalIssueMap = $this->getTotalIssueMap($scan);

        $newWarningCount = 0;
        $newErrorCount = 0;

        foreach ($totalIssueMap->getWarningMap() as $key => $total) {
            if ($previousTotalIssueMap instanceof TotalIssueMap) {
                $previousTotal = $previousTotalIssueMap->getWarningCounter($key);
                $newWarningCount += ($total - $previousTotal);
            } else {
                $newWarningCount += $total;
            }
        }

        foreach ($totalIssueMap->getErrorMap() as $key => $total) {
            if ($previousTotalIssueMap instanceof TotalIssueMap) {
                $previousTotal = $previousTotalIssueMap->getErrorCounter($key);
                $newErrorCount += ($total - $previousTotal);
            } else {
                $newErrorCount += $total;
            }
        }


        if ($persist) {
            $this->persistenceAdapter->persist($scan);
        }

        return new AnalyseResult($newWarningCount, $newErrorCount, $scan, $previousScan);
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
}
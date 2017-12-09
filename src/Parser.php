<?php


namespace cwreden\php7ccAnalyser;


class Parser
{
    /**
     * @param ScanResultFile $scanResultFile
     * @return Scan
     */
    public function parse(ScanResultFile $scanResultFile)
    {
        $result = $scanResultFile->getResult();

        $summary = new Summary(
            $result['summary']['checkedFiles']
        );

        $scannedFileCollection = new ScannedSourceFileCollection();
        foreach ($result['files'] as $file) {
            $warningIssueCollection = new IssueCollection();
            $errorIssueCollection = new IssueCollection();

            foreach ($file['warnings'] as $warning) {
                $warningIssueCollection->add(new Issue((int)$warning['line'], $warning['text']));
            }

            foreach ($file['errors'] as $error) {
                $errorIssueCollection->add(new Issue((int)$error['line'], $error['text']));
            }

            $scannedFileCollection->add(new ScannedSourceFile(
                $file['name'],
                $warningIssueCollection,
                $errorIssueCollection
            ));
        }

        return new Scan($summary, $scannedFileCollection);
    }
}
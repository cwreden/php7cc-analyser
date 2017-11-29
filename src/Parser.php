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
            $scannedFileCollection->add(new ScannedSourceFile(
                $file['name'],
                $file['warnings'],
                $file['errors']
            ));
        }

        return new Scan($summary, $scannedFileCollection);
    }
}
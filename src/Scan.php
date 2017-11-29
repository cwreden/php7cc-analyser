<?php


namespace cwreden\php7ccAnalyser;


class Scan
{
    /**
     * @var Summary
     */
    private $summary;
    /**
     * @var ScannedSourceFileCollection
     */
    private $scannedFileCollection;

    /**
     * Scan constructor.
     * @param Summary $summary
     * @param ScannedSourceFileCollection $scannedFileCollection
     */
    public function __construct(Summary $summary, ScannedSourceFileCollection $scannedFileCollection)
    {
        $this->summary = $summary;
        $this->scannedFileCollection = $scannedFileCollection;
    }

    /**
     * @return Summary
     */
    public function getSummary(): Summary
    {
        return $this->summary;
    }

    /**
     * @return int
     */
    public function getTotalWarnings()
    {
        $warnings = 0;
        /** @var ScannedSourceFile $scannedFile */
        foreach ($this->getScannedFileCollection() as $scannedFile) {
            $warnings += $scannedFile->getTotalWarnings();
        }
        return $warnings;
    }

    /**
     * @return int
     */
    public function getTotalErrors()
    {
        $errors = 0;
        /** @var ScannedSourceFile $scannedFile */
        foreach ($this->getScannedFileCollection() as $scannedFile) {
            $errors += $scannedFile->getTotalErrors();
        }
        return $errors;
    }

    /**
     * @return int
     */
    public function getTotalEffectedFiles()
    {
        return $this->getScannedFileCollection()->getTotal();
    }

    /**
     * @return ScannedSourceFileCollection
     */
    public function getScannedFileCollection(): ScannedSourceFileCollection
    {
        return $this->scannedFileCollection;
    }
}
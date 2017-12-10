<?php

namespace cwreden\php7ccAnalyser;

/**
 * Class AnalyseResult
 * @package cwreden\php7ccAnalyser
 * @deprecated
 */
class AnalyseResult
{
    /**
     * @var Scan
     */
    private $actualScan;
    /**
     * @var Scan
     */
    private $previousScan;
    /**
     * @var int
     */
    private $totalNewWarnings;
    /**
     * @var int
     */
    private $totalNewErrors;

    /**
     * AnalyseResult constructor.
     * @param int $totalNewWarnings
     * @param int $totalNewErrors
     * @param Scan $actualScan
     * @param Scan|null $previousScan
     * @deprecated
     */
    public function __construct(int $totalNewWarnings, int $totalNewErrors, Scan $actualScan, Scan $previousScan = null)
    {
        $this->actualScan = $actualScan;
        $this->previousScan = $previousScan;
        $this->totalNewWarnings = $totalNewWarnings;
        $this->totalNewErrors = $totalNewErrors;
    }

    /**
     * @return int
     */
    public function getTotalNewWarnings(): int
    {
        return $this->totalNewWarnings;
    }

    /**
     * @return int
     */
    public function getTotalNewErrors(): int
    {
        return $this->totalNewErrors;
    }

    /**
     * @return Scan
     */
    public function getActualScan(): Scan
    {
        return $this->actualScan;
    }

    public function getTotalEffectedNewFiles()
    {
        return 0;
    }
}
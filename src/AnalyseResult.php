<?php

namespace cwreden\php7ccAnalyser;


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
     * @var array
     */
    private $newWarnings;
    /**
     * @var array
     */
    private $newErrors;

    /**
     * ScanDiff constructor.
     * @param array $newWarnings
     * @param array $newErrors
     * @param Scan $actualScan
     * @param Scan $previousScan
     */
    public function __construct(array $newWarnings, array $newErrors, Scan $actualScan, Scan $previousScan = null)
    {
        $this->actualScan = $actualScan;
        $this->previousScan = $previousScan;
        $this->newWarnings = $newWarnings;
        $this->newErrors = $newErrors;
    }

    /**
     * @return array
     */
    public function getNewWarnings()
    {
        return $this->newWarnings;
    }

    /**
     * @return array
     */
    public function getNewErrors()
    {
        return $this->newErrors;
    }
}
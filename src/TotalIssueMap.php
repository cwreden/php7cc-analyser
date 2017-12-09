<?php


namespace cwreden\php7ccAnalyser;


class TotalIssueMap
{
    /**
     * @var array
     */
    private $warningMap;
    /**
     * @var array
     */
    private $errorMap;

    /**
     * TotalIssueMap constructor.
     * @param array $warningMap
     * @param array $errorMap
     */
    public function __construct(array $warningMap, array $errorMap)
    {
        $this->warningMap = $warningMap;
        $this->errorMap = $errorMap;
    }

    /**
     * @param $key
     * @return int
     */
    public function getWarningCounter($key): int
    {
        if (isset($this->warningMap[$key])) {
            return $this->warningMap[$key];
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getErrorCounter($key): int
    {
        if (isset($this->errorMap[$key])) {
            return $this->errorMap[$key];
        }
        return 0;
    }

    /**
     * @return array
     */
    public function getWarningMap(): array
    {
        return $this->warningMap;
    }

    /**
     * @return array
     */
    public function getErrorMap(): array
    {
        return $this->errorMap;
    }

}
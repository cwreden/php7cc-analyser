<?php


namespace cwreden\php7ccAnalyser;


class AnalyserEffectedFilesResult
{
    /**
     * @var array
     */
    private $files = [];

    /**
     * @var int
     */
    private $warningCounter = 0;

    /**
     * @var int
     */
    private $errorCounter = 0;

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return count($this->files);
    }

    /**
     * @param $key
     */
    public function addIfNotAlready(string $key): void
    {
        if (!in_array($key, $this->files)) {
            $this->files[] = $key;
        }
    }

    /**
     * @param int $value
     */
    public function increaseWarningCounterBy(int $value): void
    {
        $this->warningCounter += $value;
    }

    /**
     * @param int $value
     */
    public function increaseErrorCounterBy(int $value): void
    {
        $this->errorCounter += $value;
    }

    /**
     * @return int
     */
    public function getWarningCounter(): int
    {
        return $this->warningCounter;
    }

    /**
     * @return int
     */
    public function getErrorCounter(): int
    {
        return $this->errorCounter;
    }
}
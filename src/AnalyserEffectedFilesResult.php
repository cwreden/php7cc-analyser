<?php


namespace cwreden\php7ccAnalyser;


class AnalyserEffectedFilesResult
{
    private $files = [];

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return count($this->files);
    }

    public function addIfNotAlready($key)
    {
        if (!in_array($key, $this->files)) {
            $this->files[] = $key;
        }
    }
}
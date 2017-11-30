<?php

namespace cwreden\php7ccAnalyser;


class MemPersistenceAdapter implements PersistenceAdapterInterface
{
    /**
     * @var Scan
     */
    private $lastScan = null;

    /**
     * @param Scan $scan
     */
    public function persist(Scan $scan): void
    {
        $this->lastScan = $scan;
    }

    /**
     * @return Scan
     * @throws NoPreviousScanFoundException
     */
    public function getLast(): Scan
    {
        if ($this->lastScan === null) {
            throw new NoPreviousScanFoundException();
        }
        return $this->lastScan;
    }
}
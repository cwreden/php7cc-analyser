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
     */
    public function getLast(): Scan
    {
        if ($this->lastScan === null) {
            return new Scan(new Summary(0), new ScannedSourceFileCollection());
        }
        return $this->lastScan;
    }
}
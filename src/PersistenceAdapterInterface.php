<?php

namespace cwreden\php7ccAnalyser;


interface PersistenceAdapterInterface
{
    /**
     * @param Scan $scan
     */
    public function persist(Scan $scan): void;

    /**
     * @return Scan
     * @throws NoPreviousScanFoundException
     */
    public function getLast(): Scan;
}
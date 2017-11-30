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
     */
    public function getLast(): Scan;
}
<?php

namespace cwreden\php7ccAnalyser;


class FilePersistenceAdapter implements PersistenceAdapterInterface
{

    /**
     * @param Scan $scan
     */
    public function persist(Scan $scan): void
    {
        $serializedScan = serialize($scan);
        file_put_contents('./lastScan', $serializedScan);
    }

    /**
     * @return Scan
     */
    public function getLast(): Scan
    {
        if (file_exists('./lastScan')) {
            $content = file_get_contents('./lastScan');
            return unserialize($content);
        }
        return new Scan(new Summary(0), new ScannedSourceFileCollection());
    }
}
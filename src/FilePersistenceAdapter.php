<?php

namespace cwreden\php7ccAnalyser;


class FilePersistenceAdapter implements PersistenceAdapterInterface
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param Scan $scan
     */
    public function persist(Scan $scan): void
    {
        $serializedScan = serialize($scan);
        file_put_contents($this->path, $serializedScan);
    }

    /**
     * @return Scan
     * @throws NoPreviousScanFoundException
     */
    public function getLast(): Scan
    {
        if (!file_exists($this->path)) {
            throw new NoPreviousScanFoundException();
        }
        $content = file_get_contents($this->path);
        return unserialize($content);
    }
}
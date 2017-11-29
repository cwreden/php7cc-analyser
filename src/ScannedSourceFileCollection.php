<?php


namespace cwreden\php7ccAnalyser;


use Traversable;

class ScannedSourceFileCollection implements \IteratorAggregate
{
    /**
     * @var ScannedSourceFile[]
     */
    private $scannedFiles = [];

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->scannedFiles);
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return count($this->scannedFiles);
    }

    /**
     * @param ScannedSourceFile $scannedFile
     */
    public function add(ScannedSourceFile $scannedFile): void
    {
        $this->scannedFiles[] = $scannedFile;
    }
}
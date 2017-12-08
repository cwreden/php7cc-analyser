<?php


namespace cwreden\php7ccAnalyser;


use Traversable;

class IssueCollection implements \IteratorAggregate
{
    /**
     * @var Issue[]
     */
    private $issues = [];

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->issues);
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return count($this->issues);
    }

    /**
     * @param Issue $issue
     */
    public function add(Issue $issue): void
    {
        $this->issues[] = $issue;
    }
}
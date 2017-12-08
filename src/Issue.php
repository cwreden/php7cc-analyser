<?php


namespace cwreden\php7ccAnalyser;


class Issue
{
    /**
     * @var int
     */
    private $line;
    /**
     * @var string
     */
    private $text;

    /**
     * Issue constructor.
     * @param int $line
     * @param string $text
     */
    public function __construct(int $line, string $text)
    {
        $this->line = $line;
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
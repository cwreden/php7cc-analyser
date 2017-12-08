<?php


namespace cwreden\php7ccAnalyser;


class ScannedSourceFile
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var IssueCollection
     */
    private $warnings;
    /**
     * @var IssueCollection
     */
    private $errors;

    /**
     * ScannedSourceFile constructor.
     * @param $path
     * @param IssueCollection $warnings
     * @param IssueCollection $errors
     */
    public function __construct($path, IssueCollection $warnings, IssueCollection $errors)
    {
        $this->path = $path;
        $this->warnings = $warnings;
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getTotalWarnings(): int
    {
        return $this->warnings->getTotal();
    }

    /**
     * @return int
     */
    public function getTotalErrors(): int
    {
        return $this->errors->getTotal();
    }

    /**
     * @return IssueCollection
     */
    public function getWarnings(): IssueCollection
    {
        return $this->warnings;
    }

    /**
     * @return IssueCollection
     */
    public function getErrors(): IssueCollection
    {
        return $this->errors;
    }
}
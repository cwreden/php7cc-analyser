<?php


namespace cwreden\php7ccAnalyser;


class ScannedFile
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var array
     */
    private $warnings;
    /**
     * @var array
     */
    private $errors;

    /**
     * ScannedFile constructor.
     * @param string $path
     * @param array $warnings
     * @param array $errors
     */
    public function __construct($path, array $warnings, array $errors)
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
        return count($this->warnings);
    }

    /**
     * @return int
     */
    public function getTotalErrors(): int
    {
        return count($this->errors);
    }

    /**
     * @return array
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
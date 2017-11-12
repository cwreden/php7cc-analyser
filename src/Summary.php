<?php


namespace cwreden\php7ccAnalyser;


class Summary
{
    /**
     * @var int
     */
    private $checkedFiles;

    /**
     * Summary constructor.
     * @param int $checkedFiles
     */
    public function __construct(int $checkedFiles)
    {
        $this->checkedFiles = $checkedFiles;
    }

    public function getCheckedFiles(): int
    {
        return $this->checkedFiles;
    }
}
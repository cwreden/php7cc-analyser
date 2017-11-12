<?php


namespace cwreden\php7ccAnalyser;


final class ScanResultFile
{
    /**
     * @var string
     */
    private $path;

    /**
     * ScanResultFile constructor.
     * @param string $path
     * @throws ResultFileNotFoundException
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new ResultFileNotFoundException();
        }
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        $content = file_get_contents($this->getPath());
        return json_decode($content, true);
    }
}
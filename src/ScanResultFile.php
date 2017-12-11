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
        $this->ensureResultFile($path);
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
     * @throws ScanResultParsingException
     */
    public function getResult(): array
    {
        $content = file_get_contents($this->getPath());
        $json = json_decode($content, true);

        if (!is_array($json)) {
            throw new ScanResultParsingException($this->getPath());
        }
        return $json;
    }

    /**
     * @param string $path
     * @throws ResultFileNotFoundException
     */
    private function ensureResultFile(string $path): void
    {
        if (!file_exists($path)) {
            throw new ResultFileNotFoundException('php7cc result file not found.');
        }
    }
}
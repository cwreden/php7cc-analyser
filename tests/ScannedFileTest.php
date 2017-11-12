<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\ScannedFile
 */
class ScannedFileTest extends TestCase
{
    /**
     * @var ScannedFile
     */
    private $scannedFile;

    public function testGetFilePath()
    {
        $this->assertEquals('/path/to/my/directory/myfile.php', $this->scannedFile->getPath());
    }

    public function testGetTotalWarnings()
    {
        $this->assertEquals(1, $this->scannedFile->getTotalWarnings());
    }

    public function testGetTotalErrors()
    {
        $this->assertEquals(0, $this->scannedFile->getTotalErrors());
    }

    public function testGetWarnings()
    {
        $this->assertInternalType('array', $this->scannedFile->getWarnings());
    }

    public function testGetErrors()
    {
        $this->assertInternalType('array', $this->scannedFile->getErrors());
    }

    protected function setUp()
    {
        $this->scannedFile = new ScannedFile(
            '/path/to/my/directory/myfile.php',
            [
                [
                    "text" => "String containing number in hexadecimal notation",
                    "line" => 13
                ]
            ],
            []
        );
    }

    protected function tearDown()
    {
        unset($this->scannedFile);
    }

}

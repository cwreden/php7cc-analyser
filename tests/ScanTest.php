<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\Scan
 * @uses \cwreden\php7ccAnalyser\Summary
 * @uses \cwreden\php7ccAnalyser\ScannedFile
 * @uses \cwreden\php7ccAnalyser\ScannedFileCollection
 */
class ScanTest extends TestCase
{
    /**
     * @var Scan
     */
    private $scan;

    public function testGetSummary()
    {
        $this->assertInstanceOf(Summary::class, $this->scan->getSummary());
    }

    public function testGetTotalEffectedFiles()
    {
        $this->assertEquals(2, $this->scan->getTotalEffectedFiles());
    }

    public function testGetTotalWarnings()
    {
        $this->assertEquals(2, $this->scan->getTotalWarnings());
    }

    public function testGetTotalErrors()
    {
        $this->assertEquals(0, $this->scan->getTotalErrors());
    }

    protected function setUp()
    {
        $scannedFileCollection = new ScannedFileCollection();
        $scannedFileCollection->add(new ScannedFile(
            "/path/to/my/directory/myfile.php",
            [
                [
                    "text" => "String containing number in hexadecimal notation",
                    "line" => 13
                ]
            ],
            []
        ));
        $scannedFileCollection->add(new ScannedFile(
            "/path/to/my/directory/myfile.php",
            [
                [
                    "line" => 6,
                    "text" => "Reserved name \"string\" used as a class, interface or trait name "
                ]
            ],
            []
        ));

        $this->scan = new Scan(
            new Summary(2),
            $scannedFileCollection
        );
    }

    protected function tearDown()
    {
        unset($this->scan);
    }
}

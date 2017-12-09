<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\Scan
 * @uses \cwreden\php7ccAnalyser\Summary
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFile
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFileCollection
 * @uses \cwreden\php7ccAnalyser\Issue
 * @uses \cwreden\php7ccAnalyser\IssueCollection
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
        $warningCollection1 = new IssueCollection();
        $warningCollection1->add(new Issue(13, "String containing number in hexadecimal notation"));

        $warningCollection2 = new IssueCollection();
        $warningCollection2->add(new Issue(6, "Reserved name \"string\" used as a class, interface or trait name "));

        $scannedFileCollection = new ScannedSourceFileCollection();
        $scannedFileCollection->add(new ScannedSourceFile(
            "/path/to/my/directory/myfile.php",
            $warningCollection1,
            new IssueCollection()
        ));
        $scannedFileCollection->add(new ScannedSourceFile(
            "/path/to/my/directory/otherfile.php",
            $warningCollection2,
            new IssueCollection()
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

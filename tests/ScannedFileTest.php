<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\ScannedSourceFile
 * @uses \cwreden\php7ccAnalyser\Issue
 * @uses \cwreden\php7ccAnalyser\IssueCollection
 */
class ScannedFileTest extends TestCase
{
    /**
     * @var ScannedSourceFile
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
        $this->assertInstanceOf(IssueCollection::class, $this->scannedFile->getWarnings());
    }

    public function testGetErrors()
    {
        $this->assertInstanceOf(IssueCollection::class, $this->scannedFile->getErrors());
    }

    protected function setUp()
    {
        $warningCollection = new IssueCollection();
        $warningCollection->add(new Issue(13, "String containing number in hexadecimal notation"));

        $this->scannedFile = new ScannedSourceFile(
            '/path/to/my/directory/myfile.php',
            $warningCollection,
            new IssueCollection()
        );
    }

    protected function tearDown()
    {
        unset($this->scannedFile);
    }

}

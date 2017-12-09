<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\ScannedSourceFileCollection
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFile
 * @uses \cwreden\php7ccAnalyser\Issue
 * @uses \cwreden\php7ccAnalyser\IssueCollection
 */
class ScannedFileCollectionTest extends TestCase
{

    public function testAddScannedFile()
    {
        $scannedFileCollection = new ScannedSourceFileCollection();

        $warningCollection1 = new IssueCollection();
        $warningCollection1->add(new Issue(13, 'String containing number in hexadecimal notation'));

        $scannedFileCollection->add(new ScannedSourceFile(
            '/path/to/my/directory/myfile.php',
            $warningCollection1,
            new IssueCollection()
        ));


        $warningCollection2 = new IssueCollection();
        $warningCollection2->add(new Issue(6, "Reserved name \"string\" used as a class, interface or trait name "));

        $scannedFileCollection->add(new ScannedSourceFile(
            "/path/to/my/directory/otherfile.php",
            $warningCollection2,
            new IssueCollection()
        ));

        $this->assertEquals(2, $scannedFileCollection->getTotal());
    }

    public function testGetArrayIterator()
    {
        $scannedFileCollection = new ScannedSourceFileCollection();

        $this->assertInstanceOf(\ArrayIterator::class, $scannedFileCollection->getIterator());
    }
}

<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\ScannedSourceFileCollection
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFile
 */
class ScannedFileCollectionTest extends TestCase
{

    public function testAddScannedFile()
    {
        $scannedFileCollection = new ScannedSourceFileCollection();

        $scannedFileCollection->add(new ScannedSourceFile(
            '/path/to/my/directory/myfile.php',
            [
                [
                    "text" => "String containing number in hexadecimal notation",
                    "line" => 13
                ]
            ],
            []
        ));
        $scannedFileCollection->add(new ScannedSourceFile(
            "/path/to/my/directory/myfile.php",
            [
                [
                    "line" => 6,
                    "text" => "Reserved name \"string\" used as a class, interface or trait name "
                ]
            ],
            []
        ));

        $this->assertEquals(2, $scannedFileCollection->getTotal());
    }

    public function testGetArrayIterator()
    {
        $scannedFileCollection = new ScannedSourceFileCollection();

        $this->assertInstanceOf(\ArrayIterator::class, $scannedFileCollection->getIterator());
    }
}

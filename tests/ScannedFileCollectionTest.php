<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\ScannedFileCollection
 * @uses \cwreden\php7ccAnalyser\ScannedFile
 */
class ScannedFileCollectionTest extends TestCase
{

    public function testAddScannedFile()
    {
        $scannedFileCollection = new ScannedFileCollection();

        $scannedFileCollection->add(new ScannedFile(
            '/path/to/my/directory/myfile.php',
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

        $this->assertEquals(2, $scannedFileCollection->getTotal());
    }
}

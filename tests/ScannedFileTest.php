<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

class ScannedFileTest extends TestCase
{

    public function test()
    {
        $scannedFile = new ScannedFile(
            '/path/to/my/directory/myfile.php',
            [
                [
                    "text" => "String containing number in hexadecimal notation",
                    "line" => 13
                ]
            ],
            []
        );

        $this->assertEquals('/path/to/my/directory/myfile.php', $scannedFile->getPath());
        $this->assertEquals(1, $scannedFile->getTotalWarnings());
        $this->assertEquals(0, $scannedFile->getTotalErrors());
    }
}

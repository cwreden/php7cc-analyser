<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\AnalyserEffectedFilesResult
 */
class AnalyserEffectedFilesResultTest extends TestCase
{

    public function testAddDifferentKeys()
    {
        $analyserEffectedFilesResult = new AnalyserEffectedFilesResult();

        $analyserEffectedFilesResult->addIfNotAlready('key1');
        $analyserEffectedFilesResult->addIfNotAlready('key2');
        $analyserEffectedFilesResult->addIfNotAlready('key3');
        $analyserEffectedFilesResult->addIfNotAlready('key4');

        $this->assertEquals(4, $analyserEffectedFilesResult->getTotal());

        $analyserEffectedFilesResult->addIfNotAlready('key2');

        $this->assertEquals(4, $analyserEffectedFilesResult->getTotal());

        $analyserEffectedFilesResult->addIfNotAlready('key5');

        $this->assertEquals(5, $analyserEffectedFilesResult->getTotal());
    }
}

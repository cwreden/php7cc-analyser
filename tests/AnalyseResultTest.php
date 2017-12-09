<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\AnalyseResult
 * @uses \cwreden\php7ccAnalyser\Scan
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFileCollection
 * @uses \cwreden\php7ccAnalyser\Summary
 */
class AnalyseResultTest extends TestCase
{

    public function testCanGetNewWarnings()
    {
        $diff = new AnalyseResult(
            1,
            0,
            new Scan(
                new Summary(2),
                new ScannedSourceFileCollection()
            )
        );

        $this->assertEquals(1, $diff->getTotalNewWarnings());
    }

    public function testCanGetNewErrors()
    {
        $diff = new AnalyseResult(
            0,
            1,
            new Scan(
                new Summary(2),
                new ScannedSourceFileCollection()
            )
        );

        $this->assertEquals(1, $diff->getTotalNewErrors());
    }
}

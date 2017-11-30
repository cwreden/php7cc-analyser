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
        $newWarnings = [
            [
                'text' => 'test warning',
                'line' => 42
            ]
        ];
        $diff = new AnalyseResult($newWarnings, [], new Scan(new Summary(2), new ScannedSourceFileCollection()));

        $this->assertCount(1, $diff->getNewWarnings());
        $this->assertInternalType('array', $diff->getNewWarnings());
    }

    public function testCanGetNewErrors()
    {
        $newErrors = [
            [
                'text' => 'test error',
                'line' => 666
            ]
        ];
        $diff = new AnalyseResult([], $newErrors, new Scan(new Summary(2), new ScannedSourceFileCollection()));

        $this->assertCount(1, $diff->getNewErrors());
        $this->assertInternalType('array', $diff->getNewErrors());
    }
}

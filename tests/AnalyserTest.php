<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\Analyser
 * @uses \cwreden\php7ccAnalyser\Parser
 * @uses \cwreden\php7ccAnalyser\ScanResultFile
 * @uses \cwreden\php7ccAnalyser\Scan
 * @uses \cwreden\php7ccAnalyser\AnalyseResult
 * @uses \cwreden\php7ccAnalyser\Summary
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFile
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFileCollection
 * @uses \cwreden\php7ccAnalyser\MemPersistenceAdapter
 * @uses \cwreden\php7ccAnalyser\Issue
 * @uses \cwreden\php7ccAnalyser\IssueCollection
 * @uses \cwreden\php7ccAnalyser\TotalIssueMap
 */
class AnalyserTest extends TestCase
{

    public function testAnalyseWithoutPreviousScan()
    {
        $analyser = new Analyser(new MemPersistenceAdapter());

        $scanResultFile = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');
        $result = $analyser->analyse($scanResultFile);

        $this->assertInstanceOf(AnalyseResult::class, $result);
        $this->assertEquals(0, $result->getTotalNewErrors());
        $this->assertEquals(3, $result->getTotalNewWarnings());
        }

    public function testAnalyseWithEqualORLessScan()
    {
        $analyser = new Analyser(new MemPersistenceAdapter());

        $scanResultFile1 = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');
        $result1 = $analyser->analyse($scanResultFile1);

        $this->assertInstanceOf(AnalyseResult::class, $result1);

        $scanResultFile2 = new ScanResultFile(__DIR__ . '/fixtures/resultEquals.json');
        $result2 = $analyser->analyse($scanResultFile2, false);

        $this->assertInstanceOf(AnalyseResult::class, $result2);
        $this->assertEquals(0, $result2->getTotalNewWarnings(), 'Invalid number of warnings');
        $this->assertEquals(0, $result2->getTotalNewErrors(), 'Invalid number of errors');
    }

    public function testAnalyseWithDifferentScan()
    {
        $analyser = new Analyser(new MemPersistenceAdapter());

        $scanResultFile1 = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');
        $result1 = $analyser->analyse($scanResultFile1);

        $this->assertInstanceOf(AnalyseResult::class, $result1);

        $scanResultFile2 = new ScanResultFile(__DIR__ . '/fixtures/resultDifferent.json');
        $result2 = $analyser->analyse($scanResultFile2, false);

        $this->assertInstanceOf(AnalyseResult::class, $result2);
        $this->assertEquals(1, $result2->getTotalNewWarnings(), 'Invalid number of warnings');
        $this->assertEquals(1, $result2->getTotalNewErrors(), 'Invalid number of errors');
    }
}

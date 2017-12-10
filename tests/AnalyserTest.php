<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;

/**
 * @covers \cwreden\php7ccAnalyser\Analyser
 * @uses \cwreden\php7ccAnalyser\Parser
 * @uses \cwreden\php7ccAnalyser\ScanResultFile
 * @uses \cwreden\php7ccAnalyser\Scan
 * @uses \cwreden\php7ccAnalyser\Summary
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFile
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFileCollection
 * @uses \cwreden\php7ccAnalyser\MemPersistenceAdapter
 * @uses \cwreden\php7ccAnalyser\Issue
 * @uses \cwreden\php7ccAnalyser\IssueCollection
 * @uses \cwreden\php7ccAnalyser\TotalIssueMap
 * @uses \cwreden\php7ccAnalyser\AnalyserEffectedFilesResult
 */
class AnalyserTest extends TestCase
{
    /**
     * @var Analyser
     */
    private $analyser;

    public function testAnalyseWithoutPreviousScan()
    {
        $scanResultFile = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');
        $result = $this->analyser->analyse($scanResultFile);

        $this->assertEquals(Analyser::RESULT_STATUS_FAILURES, $result);
        }

    public function testAnalyseWithEqualORLessScan()
    {
        $scanResultFile1 = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');
        $result1 = $this->analyser->analyse($scanResultFile1);

        $this->assertEquals(Analyser::RESULT_STATUS_FAILURES, $result1);

        $scanResultFile2 = new ScanResultFile(__DIR__ . '/fixtures/resultEquals.json');
        $result2 = $this->analyser->analyse($scanResultFile2, false);

        $this->assertEquals(Analyser::RESULT_STATUS_OK, $result2);
    }

    public function testAnalyseWithDifferentScan()
    {
        $scanResultFile1 = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');
        $result1 = $this->analyser->analyse($scanResultFile1);

        $this->assertEquals(Analyser::RESULT_STATUS_FAILURES, $result1);

        $scanResultFile2 = new ScanResultFile(__DIR__ . '/fixtures/resultDifferent.json');
        $result2 = $this->analyser->analyse($scanResultFile2, false);

        $this->assertEquals(Analyser::RESULT_STATUS_FAILURES, $result2);
    }

    protected function setUp()
    {
        $this->analyser = new Analyser(
            new NullOutput(),
            new MemPersistenceAdapter()
        );
    }
}

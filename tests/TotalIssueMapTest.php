<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\TotalIssueMap
 */
class TotalIssueMapTest extends TestCase
{
    /**
     * @var TotalIssueMap
     */
    private $totalIssueMap;

    public function testGetWarningCounter()
    {
        $this->assertEquals(2, $this->totalIssueMap->getWarningCounter('testPath'));
        $this->assertEquals(0, $this->totalIssueMap->getWarningCounter('testPath2'));
    }

    public function testGetErrorCounter()
    {
        $this->assertEquals(0, $this->totalIssueMap->getErrorCounter('testPath'));
        $this->assertEquals(1, $this->totalIssueMap->getErrorCounter('testPath2'));
    }

    public function testGetWarningMap()
    {
        $this->assertInternalType('array', $this->totalIssueMap->getWarningMap());
    }

    public function testGetErrorMap()
    {
        $this->assertInternalType('array', $this->totalIssueMap->getWarningMap());
    }

    protected function setUp()
    {
        $warningMap = [
            'testPath' => 2,
            'testPath2' => 0
        ];
        $errorMap = [
            'testPath' => 0,
            'testPath2' => 1
        ];
        $this->totalIssueMap = new TotalIssueMap($warningMap, $errorMap);
    }

}

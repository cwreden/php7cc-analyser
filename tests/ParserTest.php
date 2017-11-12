<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\Parser
 */
class ParserTest extends TestCase
{
    /**
     * @uses \cwreden\php7ccAnalyser\Scan
     * @uses \cwreden\php7ccAnalyser\ScanResultFile
     */
    public function testParsePhp7CcResult()
    {
        $scanAnalyser = new Parser();

        $scanResultFile = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');
        $scan = $scanAnalyser->parse($scanResultFile);

        $this->assertInstanceOf(Scan::class, $scan);
    }
}

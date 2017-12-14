<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\ScanResultFile
 */
class ScanResultFileTest extends TestCase
{

    public function testCanBeConstructedByExistingResultFile()
    {
        $scanResultFile = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');

        $this->assertInstanceOf(ScanResultFile::class, $scanResultFile);
    }

    /**
     * @uses \cwreden\php7ccAnalyser\ResultFileNotFoundException
     */
    public function testCanNotBeConstructByNotExistingResultFile()
    {
        $this->expectException(ResultFileNotFoundException::class);

        new ScanResultFile(__DIR__ . '/fixtures/xxx.json');
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testGetResultAsArray()
    {
        $scanResultFile = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');

        $this->assertInternalType('array', $scanResultFile->getResult());
    }

    /**
     * @covers \cwreden\php7ccAnalyser\ScanResultParsingException
     * @throws ScanResultParsingException
     */
    public function testPreventEmptyResultFile()
    {
        $this->expectException(ScanResultParsingException::class);

        $scanResultFile = new ScanResultFile(__DIR__ . '/fixtures/emptyFile.json');

        $scanResultFile->getResult();
    }
}

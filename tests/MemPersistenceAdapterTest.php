<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\MemPersistenceAdapter
 * @uses \cwreden\php7ccAnalyser\Scan
 * @uses \cwreden\php7ccAnalyser\Summary
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFileCollection
 */
class MemPersistenceAdapterTest extends TestCase
{

    public function testPersistScan()
    {
        $scan = new Scan(new Summary(4), new ScannedSourceFileCollection());

        $memPersistenceAdapter = new MemPersistenceAdapter();

        $memPersistenceAdapter->persist($scan);

        $this->assertEquals($scan, $memPersistenceAdapter->getLast());
    }

    public function testLoadTheVeryLastPersistedScan()
    {
        $firstScan = new Scan(new Summary(4), new ScannedSourceFileCollection());
        $secondScan = new Scan(new Summary(21), new ScannedSourceFileCollection());

        $memPersistenceAdapter = new MemPersistenceAdapter();

        $memPersistenceAdapter->persist($firstScan);
        $memPersistenceAdapter->persist($secondScan);

        $this->assertEquals($secondScan, $memPersistenceAdapter->getLast());
    }

    public function testGetDummyScanIfNothingWasPersisted()
    {
        $memPersistenceAdapter = new MemPersistenceAdapter();

        $scan = $memPersistenceAdapter->getLast();
        $this->assertEquals(0, $scan->getSummary()->getCheckedFiles());
        $this->assertEquals(0, $scan->getScannedFileCollection()->getTotal());
    }
}

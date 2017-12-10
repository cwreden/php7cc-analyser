<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\FilePersistenceAdapter
 * @uses \cwreden\php7ccAnalyser\Scan
 * @uses \cwreden\php7ccAnalyser\Summary
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFileCollection
 */
class FilePersistenceAdapterTest extends TestCase
{
    /**
     * @var FilePersistenceAdapter
     */
    private $persistenceAdapter;
    /**
     * @var Scan
     */
    private $scan;
    /**
     * @var string
     */
    private $tmpPath;

    /**
     * @throws NoPreviousScanFoundException
     */
    public function testPersistScanAndLoad()
    {
        $this->persistenceAdapter->persist($this->scan);

        $scan = $this->persistenceAdapter->getLast();

        $this->assertEquals($this->scan, $scan);
    }

    /**
     * @throws NoPreviousScanFoundException
     */
    public function testNoScanFound()
    {
        $this->expectException(NoPreviousScanFoundException::class);

        $this->persistenceAdapter->getLast();
    }

    protected function setUp()
    {
        $this->scan = new Scan(
            new Summary(15),
            new ScannedSourceFileCollection()
        );

        $this->tmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'lastScan';

        $this->persistenceAdapter = new FilePersistenceAdapter($this->tmpPath);
    }

    protected function tearDown()
    {
        if (file_exists($this->tmpPath)) {
            unlink($this->tmpPath);
        }
    }

}

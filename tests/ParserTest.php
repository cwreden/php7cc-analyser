<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\Parser
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFile
 * @uses \cwreden\php7ccAnalyser\ScannedSourceFileCollection
 * @uses \cwreden\php7ccAnalyser\Summary
 * @uses \cwreden\php7ccAnalyser\IssueCollection
 * @uses \cwreden\php7ccAnalyser\Issue
 * @uses \cwreden\php7ccAnalyser\ScanResultFile
 * @uses \cwreden\php7ccAnalyser\ScanResultParsingException
 */
class ParserTest extends TestCase
{
    /**
     * @var string
     */
    private $tmpJsonFile;

    /**
     * @uses \cwreden\php7ccAnalyser\Scan
     * @throws ScanResultParsingException
     */
    public function testParsePhp7CcResult()
    {
        $parser = new Parser();

        $scanResultFile = new ScanResultFile(__DIR__ . '/fixtures/resultExample.json');
        $scan = $parser->parse($scanResultFile);

        $this->assertInstanceOf(Scan::class, $scan);
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventEmptyJsonFile()
    {
        $data = [];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventInvalidSummary()
    {
        $data = [
            'summary' => []
        ];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventMissingAttributeFiles()
    {
        $data = [
            'summary' => [
                'checkedFiles' => 12
            ]
        ];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventMissingFileName()
    {
        $data = [
            'summary' => [
                'checkedFiles' => 12
            ],
            'files' => [
                [

                ]
            ]
        ];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventMissingFileAttributeWarnings()
    {
        $data = [
            'summary' => [
                'checkedFiles' => 12
            ],
            'files' => [
                [
                    'name' => '/path/to/file'
                ]
            ]
        ];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventMissingFileAttributeErrors()
    {
        $data = [
            'summary' => [
                'checkedFiles' => 12
            ],
            'files' => [
                [
                    'name' => '/path/to/file',
                    'warnings' => []
                ]
            ]
        ];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventWarningIssueMissingAttributeLine()
    {
        $data = [
            'summary' => [
                'checkedFiles' => 12
            ],
            'files' => [
                [
                    'name' => '/path/to/file',
                    'warnings' => [
                        []
                    ],
                    'errors' => []
                ]
            ]
        ];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventWarningIssueMissingAttributeText()
    {
        $data = [
            'summary' => [
                'checkedFiles' => 12
            ],
            'files' => [
                [
                    'name' => '/path/to/file',
                    'warnings' => [
                        [
                            'line' => 12
                        ]
                    ],
                    'errors' => []
                ]
            ]
        ];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventErrorIssueMissingAttributeLine()
    {
        $data = [
            'summary' => [
                'checkedFiles' => 12
            ],
            'files' => [
                [
                    'name' => '/path/to/file',
                    'warnings' => [],
                    'errors' => [
                        []
                    ]
                ]
            ]
        ];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @throws ScanResultParsingException
     */
    public function testPreventErrorIssueMissingAttributeText()
    {
        $data = [
            'summary' => [
                'checkedFiles' => 12
            ],
            'files' => [
                [
                    'name' => '/path/to/file',
                    'warnings' => [],
                    'errors' => [
                        [
                            'line' => 42
                        ]
                    ]
                ]
            ]
        ];
        $this->createJsonFile($data);

        $this->expectException(ScanResultParsingException::class);

        $parser = new Parser();
        $parser->parse(new ScanResultFile($this->tmpJsonFile));
    }

    /**
     * @param $data
     */
    private function createJsonFile(array $data): void
    {
        file_put_contents($this->tmpJsonFile, json_encode($data));
    }

    protected function setUp()
    {
        $this->tmpJsonFile = sys_get_temp_dir() . '/parserResult.json';
    }

    protected function tearDown()
    {
        if (file_exists($this->tmpJsonFile)) {
            unlink($this->tmpJsonFile);
        }
    }
}

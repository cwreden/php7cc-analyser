<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

class SummaryTest extends TestCase
{

    public function testCheckedFilesCounter()
    {
        $summary = new Summary(42);

        $this->assertEquals(42, $summary->getCheckedFiles());
    }
}

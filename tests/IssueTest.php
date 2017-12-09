<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\Issue
 */
class IssueTest extends TestCase
{

    public function testCanBeConstructed()
    {
        $issue = new Issue(17, 'Test issue');

        $this->assertInstanceOf(Issue::class, $issue);

        $this->assertEquals(17, $issue->getLine());
        $this->assertEquals('Test issue', $issue->getText());
    }
}

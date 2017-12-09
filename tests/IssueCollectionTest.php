<?php

namespace cwreden\php7ccAnalyser;

use PHPUnit\Framework\TestCase;

/**
 * @covers \cwreden\php7ccAnalyser\IssueCollection
 * @uses \cwreden\php7ccAnalyser\Issue
 */
class IssueCollectionTest extends TestCase
{

    public function testCanBeConstructed()
    {
        $issueCollection = new IssueCollection();

        $this->assertInstanceOf(IssueCollection::class, $issueCollection);
    }

    public function testGetIterator()
    {
        $issueCollection = new IssueCollection();

        $issueCollection->add(new Issue(17, 'Test issue 1'));
        $issueCollection->add(new Issue(6, 'Test issue 2'));
        $issueCollection->add(new Issue(56, 'Test issue 3'));


        $traversable = $issueCollection->getIterator();

        foreach ($traversable as $item) {
            $this->assertInstanceOf(Issue::class, $item);
        }
    }

    public function testGetTotalOfTree()
    {
        $issueCollection = new IssueCollection();

        $issueCollection->add(new Issue(17, 'Test issue 1'));
        $issueCollection->add(new Issue(6, 'Test issue 2'));
        $issueCollection->add(new Issue(56, 'Test issue 3'));

        $this->assertEquals(3, $issueCollection->getTotal());
    }
}

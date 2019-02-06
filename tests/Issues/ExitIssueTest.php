<?php

use PhpParser\Node\Expr\Exit_;

require_once __DIR__ . '/../../vendor/autoload.php';

use edsonmedina\php_testability\Issues\ExitIssue;

class ExitIssueTest extends PHPUnit\Framework\TestCase
{
    /**
     * @covers \edsonmedina\php_testability\Issues\ExitIssue::getTitle
     */
    public function testGetTitle()
    {
        $node = $this->getMockBuilder(Exit_::class)
                     ->disableOriginalConstructor()
                     ->getMock();

        $issue = new ExitIssue($node);

        $this->assertEquals('Exit', $issue->getTitle());
    }

    /**
     * @covers \edsonmedina\php_testability\Issues\ExitIssue::getID
     */
    public function testGetID()
    {
        $node = $this->getMockBuilder(Exit_::class)
                     ->disableOriginalConstructor()
                     ->getMock();

        $issue = new ExitIssue($node);

        $this->assertEquals('', $issue->getID());
    }
}

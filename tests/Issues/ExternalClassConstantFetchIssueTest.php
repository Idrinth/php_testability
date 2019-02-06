<?php

use PhpParser\Node\Stmt\Class_;

require_once __DIR__ . '/../../vendor/autoload.php';

use edsonmedina\php_testability\Issues\ExternalClassConstantFetchIssue;

class ExternalClassConstantFetchIssueTest extends PHPUnit\Framework\TestCase
{
    /**
     * @covers \edsonmedina\php_testability\Issues\ExternalClassConstantFetchIssue::getTitle
     */
    public function testGetTitle()
    {
        $node = $this->getMockBuilder(Class_::class)
                     ->disableOriginalConstructor()
                     ->getMock();

        $issue = new ExternalClassConstantFetchIssue($node);

        $this->assertEquals('External class constant fetch', $issue->getTitle());
    }
}

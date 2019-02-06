<?php
namespace edsonmedina\php_testability\NodeVisitors;

use edsonmedina\php_testability\VisitorAbstract;
use edsonmedina\php_testability\Issues\CodeOnGlobalSpaceIssue;
use PhpParser;
use PhpParser\Node;
use PhpParser\Node\Stmt;

class CodeInGlobalSpaceVisitor extends VisitorAbstract
{
    public function enterNode(PhpParser\Node $node)
    {
        if ($node instanceof Stmt\Declare_) {
            return PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }

        // check for code outside of classes/functions
        if ($this->inGlobalScope()) {
            if (!$this->isAllowedOnGlobalSpace($node)) {
                $this->stack->addIssue(new CodeOnGlobalSpaceIssue($node));
            }
        }
    }

    /**
     * Is node allowed on global space?
     * @param PhpParser\Node $node
     * @return bool
     */
    public function isAllowedOnGlobalSpace(PhpParser\Node $node)
    {
        return (
                $node instanceof Stmt\Class_
                || $node instanceof Stmt\Function_
                || $node instanceof Stmt\Trait_
                || ($node instanceof Stmt\UseUse || $node instanceof Stmt\Use_)
                || ($node instanceof Stmt\Namespace_ || $node instanceof Node\Name)
                || $node instanceof Stmt\Interface_
            );
    }
}

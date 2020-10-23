<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\ORM\Query\AST\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class IfFunction extends FunctionNode
{
    /**
     * @var array<mixed>
     */
    private $expr = [];

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr[] = $parser->ConditionalExpression();

        for ($i = 0; $i < 2; $i++) {
            $parser->match(Lexer::T_COMMA);
            $this->expr[] = $parser->ArithmeticExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'IF(%s, %s, %s)',
            $sqlWalker->walkConditionalExpression($this->expr[0]),
            $sqlWalker->walkArithmeticPrimary($this->expr[1]),
            $sqlWalker->walkArithmeticPrimary($this->expr[2])
        );
    }
}

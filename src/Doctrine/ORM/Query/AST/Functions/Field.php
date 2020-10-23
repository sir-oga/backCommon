<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\ORM\Query\AST\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\ParenthesisExpression;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class Field extends FunctionNode
{
    /**
     * @var ParenthesisExpression
     */
    private $field;

    /**
     * @var ParenthesisExpression[]
     */
    private $values = [];

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        // Do the field.
        $this->field = $parser->ArithmeticPrimary();

        // Add the strings to the values array. FIELD must
        // be used with at least 1 string not including the field.

        $lexer = $parser->getLexer();

        while (
            count($this->values) < 1
            || ($lexer->lookahead['type'] ?? null) != Lexer::T_CLOSE_PARENTHESIS
        ) {
            $parser->match(Lexer::T_COMMA);
            $this->values[] = $parser->ArithmeticPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $query = '(CASE ' . $this->field->dispatch($sqlWalker);
        for ($i = 0, $limiti = count($this->values); $i < $limiti; $i++) {
            $query .= ' WHEN ' . $this->values[$i]->dispatch($sqlWalker) . ' THEN     ' . $i;
        }
        $query .= ' END)';

        return $query;
    }
}

<?php

namespace App\Doctrine;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Usage: MATCH_AGAINST(column[, column, ;;.], :text)
 * "MATCH_AGAINST" "(" {StateFieldPathExpression ","}* Literal ")"
 */
class MatchAgainst extends FunctionNode
{
	/**
	 * @var array $columns
	 * @var string $needle
	 */
	private $columns = [], $needle;

	/**
	 * @param Parser $parser
	 * @throws \Doctrine\ORM\Query\QueryException
	 */
	public function parse(Parser $parser)
	{
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);

		do {
			$this->columns[] = $parser->StateFieldPathExpression();
			$parser->match(Lexer::T_COMMA);
		}
		while ($parser->getLexer()->isNextToken(Lexer::T_IDENTIFIER));
		$this->needle = $parser->InputParameter();

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}

	public function getSql(SqlWalker $sqlWalker)
	{
		$haystack = null;

		$first = true;
		foreach ($this->columns as $column) {
			$first ? $first = false : $haystack .= ', ';
			$haystack .= $column->dispatch($sqlWalker);
		}

		return 'MATCH(' .
			$haystack .
			') AGAINST (' .
			$this->needle->dispatch($sqlWalker) .
			' IN NATURAL LANGUAGE MODE )';
	}
}
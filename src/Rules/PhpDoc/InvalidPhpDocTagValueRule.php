<?php declare(strict_types = 1);

namespace PHPStan\Rules\PhpDoc;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use function sprintf;
use function strpos;

/**
 * @implements Rule<Node>
 */
class InvalidPhpDocTagValueRule implements Rule
{

	private Lexer $phpDocLexer;

	private PhpDocParser $phpDocParser;

	public function __construct(Lexer $phpDocLexer, PhpDocParser $phpDocParser)
	{
		$this->phpDocLexer = $phpDocLexer;
		$this->phpDocParser = $phpDocParser;
	}

	public function getNodeType(): string
	{
		return Node::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if (
			!$node instanceof Node\Stmt\ClassLike
			&& !$node instanceof Node\FunctionLike
			&& !$node instanceof Node\Stmt\Foreach_
			&& !$node instanceof Node\Stmt\Property
			&& !$node instanceof Node\Expr\Assign
			&& !$node instanceof Node\Expr\AssignRef
			&& !$node instanceof Node\Stmt\ClassConst
		) {
			return [];
		}

		$docComment = $node->getDocComment();
		if ($docComment === null) {
			return [];
		}

		$phpDocString = $docComment->getText();
		$tokens = new TokenIterator($this->phpDocLexer->tokenize($phpDocString));
		$phpDocNode = $this->phpDocParser->parse($tokens);

		$errors = [];
		foreach ($phpDocNode->getTags() as $phpDocTag) {
			if (!($phpDocTag->value instanceof InvalidTagValueNode)) {
				continue;
			}

			if (strpos($phpDocTag->name, '@psalm-') === 0) {
				continue;
			}

			$errors[] = RuleErrorBuilder::message(sprintf(
				'PHPDoc tag %s has invalid value (%s): %s',
				$phpDocTag->name,
				$phpDocTag->value->value,
				$phpDocTag->value->exception->getMessage(),
			))->build();
		}

		return $errors;
	}

}

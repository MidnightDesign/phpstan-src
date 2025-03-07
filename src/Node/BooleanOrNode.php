<?php declare(strict_types = 1);

namespace PHPStan\Node;

use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use PhpParser\NodeAbstract;
use PHPStan\Analyser\Scope;

/** @api */
class BooleanOrNode extends NodeAbstract implements VirtualNode
{

	private BooleanOr|LogicalOr $originalNode;

	private Scope $rightScope;

	/**
	 * @param BooleanOr|LogicalOr $originalNode
	 */
	public function __construct($originalNode, Scope $rightScope)
	{
		parent::__construct($originalNode->getAttributes());
		$this->originalNode = $originalNode;
		$this->rightScope = $rightScope;
	}

	/**
	 * @return BooleanOr|LogicalOr
	 */
	public function getOriginalNode()
	{
		return $this->originalNode;
	}

	public function getRightScope(): Scope
	{
		return $this->rightScope;
	}

	public function getType(): string
	{
		return 'PHPStan_Node_BooleanOrNode';
	}

	/**
	 * @return string[]
	 */
	public function getSubNodeNames(): array
	{
		return [];
	}

}

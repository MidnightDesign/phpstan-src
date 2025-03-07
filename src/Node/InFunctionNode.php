<?php declare(strict_types = 1);

namespace PHPStan\Node;

use PhpParser\Node;

/** @api */
class InFunctionNode extends Node\Stmt implements VirtualNode
{

	private Node\Stmt\Function_ $originalNode;

	public function __construct(Node\Stmt\Function_ $originalNode)
	{
		parent::__construct($originalNode->getAttributes());
		$this->originalNode = $originalNode;
	}

	public function getOriginalNode(): Node\Stmt\Function_
	{
		return $this->originalNode;
	}

	public function getType(): string
	{
		return 'PHPStan_Stmt_InFunctionNode';
	}

	/**
	 * @return string[]
	 */
	public function getSubNodeNames(): array
	{
		return [];
	}

}

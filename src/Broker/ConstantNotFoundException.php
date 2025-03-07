<?php declare(strict_types = 1);

namespace PHPStan\Broker;

use PHPStan\AnalysedCodeException;
use function sprintf;

class ConstantNotFoundException extends AnalysedCodeException
{

	private string $constantName;

	public function __construct(string $constantName)
	{
		parent::__construct(sprintf('Constant %s not found.', $constantName));
		$this->constantName = $constantName;
	}

	public function getConstantName(): string
	{
		return $this->constantName;
	}

	public function getTip(): ?string
	{
		return 'Learn more at https://phpstan.org/user-guide/discovering-symbols';
	}

}

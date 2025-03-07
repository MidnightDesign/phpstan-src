<?php declare(strict_types = 1);

namespace PHPStan\Reflection\Annotations;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;

class AnnotationPropertyReflection implements PropertyReflection
{

	private ClassReflection $declaringClass;

	private Type $type;

	private bool $readable;

	private bool $writable;

	public function __construct(
		ClassReflection $declaringClass,
		Type $type,
		bool $readable = true,
		bool $writable = true,
	)
	{
		$this->declaringClass = $declaringClass;
		$this->type = $type;
		$this->readable = $readable;
		$this->writable = $writable;
	}

	public function getDeclaringClass(): ClassReflection
	{
		return $this->declaringClass;
	}

	public function isStatic(): bool
	{
		return false;
	}

	public function isPrivate(): bool
	{
		return false;
	}

	public function isPublic(): bool
	{
		return true;
	}

	public function getReadableType(): Type
	{
		return $this->type;
	}

	public function getWritableType(): Type
	{
		return $this->type;
	}

	public function canChangeTypeAfterAssignment(): bool
	{
		return true;
	}

	public function isReadable(): bool
	{
		return $this->readable;
	}

	public function isWritable(): bool
	{
		return $this->writable;
	}

	public function isDeprecated(): TrinaryLogic
	{
		return TrinaryLogic::createNo();
	}

	public function getDeprecatedDescription(): ?string
	{
		return null;
	}

	public function isInternal(): TrinaryLogic
	{
		return TrinaryLogic::createNo();
	}

	public function getDocComment(): ?string
	{
		return null;
	}

}

<?php declare(strict_types = 1);

namespace PHPStan\Reflection\Type;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Dummy\ChangedTypeMethodReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\Reflection\Php\DummyParameter;
use PHPStan\Reflection\ResolvedMethodReflection;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeTraverser;
use function array_map;

class CalledOnTypeUnresolvedMethodPrototypeReflection implements UnresolvedMethodPrototypeReflection
{

	private MethodReflection $methodReflection;

	private ClassReflection $resolvedDeclaringClass;

	private bool $resolveTemplateTypeMapToBounds;

	private Type $calledOnType;

	private ?MethodReflection $transformedMethod = null;

	private ?self $cachedDoNotResolveTemplateTypeMapToBounds = null;

	public function __construct(
		MethodReflection $methodReflection,
		ClassReflection $resolvedDeclaringClass,
		bool $resolveTemplateTypeMapToBounds,
		Type $calledOnType,
	)
	{
		$this->methodReflection = $methodReflection;
		$this->resolvedDeclaringClass = $resolvedDeclaringClass;
		$this->resolveTemplateTypeMapToBounds = $resolveTemplateTypeMapToBounds;
		$this->calledOnType = $calledOnType;
	}

	public function doNotResolveTemplateTypeMapToBounds(): UnresolvedMethodPrototypeReflection
	{
		if ($this->cachedDoNotResolveTemplateTypeMapToBounds !== null) {
			return $this->cachedDoNotResolveTemplateTypeMapToBounds;
		}

		return $this->cachedDoNotResolveTemplateTypeMapToBounds = new self(
			$this->methodReflection,
			$this->resolvedDeclaringClass,
			false,
			$this->calledOnType,
		);
	}

	public function getNakedMethod(): MethodReflection
	{
		return $this->methodReflection;
	}

	public function getTransformedMethod(): MethodReflection
	{
		if ($this->transformedMethod !== null) {
			return $this->transformedMethod;
		}
		$templateTypeMap = $this->resolvedDeclaringClass->getActiveTemplateTypeMap();

		return $this->transformedMethod = new ResolvedMethodReflection(
			$this->transformMethodWithStaticType($this->resolvedDeclaringClass, $this->methodReflection),
			$this->resolveTemplateTypeMapToBounds ? $templateTypeMap->resolveToBounds() : $templateTypeMap,
		);
	}

	public function withCalledOnType(Type $type): UnresolvedMethodPrototypeReflection
	{
		return new self(
			$this->methodReflection,
			$this->resolvedDeclaringClass,
			$this->resolveTemplateTypeMapToBounds,
			$type,
		);
	}

	private function transformMethodWithStaticType(ClassReflection $declaringClass, MethodReflection $method): MethodReflection
	{
		$variants = array_map(fn (ParametersAcceptor $acceptor): ParametersAcceptor => new FunctionVariant(
			$acceptor->getTemplateTypeMap(),
			$acceptor->getResolvedTemplateTypeMap(),
			array_map(fn (ParameterReflection $parameter): ParameterReflection => new DummyParameter(
				$parameter->getName(),
				$this->transformStaticType($parameter->getType()),
				$parameter->isOptional(),
				$parameter->passedByReference(),
				$parameter->isVariadic(),
				$parameter->getDefaultValue(),
			), $acceptor->getParameters()),
			$acceptor->isVariadic(),
			$this->transformStaticType($acceptor->getReturnType()),
		), $method->getVariants());

		return new ChangedTypeMethodReflection($declaringClass, $method, $variants);
	}

	private function transformStaticType(Type $type): Type
	{
		return TypeTraverser::map($type, function (Type $type, callable $traverse): Type {
			if ($type instanceof StaticType) {
				return $this->calledOnType;
			}

			return $traverse($type);
		});
	}

}

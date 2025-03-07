<?php declare(strict_types = 1);

namespace PHPStan\PhpDoc;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\FileTypeMapper;
use ReflectionParameter;
use function array_map;
use function strtolower;

class PhpDocInheritanceResolver
{

	private FileTypeMapper $fileTypeMapper;

	private StubPhpDocProvider $stubPhpDocProvider;

	public function __construct(
		FileTypeMapper $fileTypeMapper,
		StubPhpDocProvider $stubPhpDocProvider,
	)
	{
		$this->fileTypeMapper = $fileTypeMapper;
		$this->stubPhpDocProvider = $stubPhpDocProvider;
	}

	public function resolvePhpDocForProperty(
		?string $docComment,
		ClassReflection $classReflection,
		string $classReflectionFileName,
		?string $declaringTraitName,
		string $propertyName,
	): ResolvedPhpDocBlock
	{
		$phpDocBlock = PhpDocBlock::resolvePhpDocBlockForProperty(
			$docComment,
			$classReflection,
			null,
			$propertyName,
			$classReflectionFileName,
			null,
			[],
			[],
		);

		return $this->docBlockTreeToResolvedDocBlock($phpDocBlock, $declaringTraitName, null, $propertyName, null);
	}

	public function resolvePhpDocForConstant(
		?string $docComment,
		ClassReflection $classReflection,
		string $classReflectionFileName,
		string $constantName,
	): ResolvedPhpDocBlock
	{
		$phpDocBlock = PhpDocBlock::resolvePhpDocBlockForConstant(
			$docComment,
			$classReflection,
			null,
			$constantName,
			$classReflectionFileName,
			null,
			[],
			[],
		);

		return $this->docBlockTreeToResolvedDocBlock($phpDocBlock, null, null, null, $constantName);
	}

	/**
	 * @param array<int, string> $positionalParameterNames
	 */
	public function resolvePhpDocForMethod(
		?string $docComment,
		string $fileName,
		ClassReflection $classReflection,
		?string $declaringTraitName,
		string $methodName,
		array $positionalParameterNames,
	): ResolvedPhpDocBlock
	{
		$phpDocBlock = PhpDocBlock::resolvePhpDocBlockForMethod(
			$docComment,
			$classReflection,
			$declaringTraitName,
			$methodName,
			$fileName,
			null,
			$positionalParameterNames,
			$positionalParameterNames,
		);

		return $this->docBlockTreeToResolvedDocBlock($phpDocBlock, $phpDocBlock->getTrait(), $methodName, null, null);
	}

	private function docBlockTreeToResolvedDocBlock(PhpDocBlock $phpDocBlock, ?string $traitName, ?string $functionName, ?string $propertyName, ?string $constantName): ResolvedPhpDocBlock
	{
		$parents = [];
		$parentPhpDocBlocks = [];

		foreach ($phpDocBlock->getParents() as $parentPhpDocBlock) {
			if (
				$parentPhpDocBlock->getClassReflection()->isBuiltin()
				&& $functionName !== null
				&& strtolower($functionName) === '__construct'
			) {
				continue;
			}
			$parents[] = $this->docBlockTreeToResolvedDocBlock(
				$parentPhpDocBlock,
				$parentPhpDocBlock->getTrait(),
				$functionName,
				$propertyName,
				$constantName,
			);
			$parentPhpDocBlocks[] = $parentPhpDocBlock;
		}

		$oneResolvedDockBlock = $this->docBlockToResolvedDocBlock($phpDocBlock, $traitName, $functionName, $propertyName, $constantName);
		return $oneResolvedDockBlock->merge($parents, $parentPhpDocBlocks);
	}

	private function docBlockToResolvedDocBlock(PhpDocBlock $phpDocBlock, ?string $traitName, ?string $functionName, ?string $propertyName, ?string $constantName): ResolvedPhpDocBlock
	{
		$classReflection = $phpDocBlock->getClassReflection();
		if ($functionName !== null && $classReflection->getNativeReflection()->hasMethod($functionName)) {
			$methodReflection = $classReflection->getNativeReflection()->getMethod($functionName);
			$stub = $this->stubPhpDocProvider->findMethodPhpDoc($classReflection->getName(), $functionName, array_map(static fn (ReflectionParameter $parameter): string => $parameter->getName(), $methodReflection->getParameters()));
			if ($stub !== null) {
				return $stub;
			}
		}

		if ($propertyName !== null && $classReflection->getNativeReflection()->hasProperty($propertyName)) {
			$stub = $this->stubPhpDocProvider->findPropertyPhpDoc($classReflection->getName(), $propertyName);
			if ($stub !== null) {
				return $stub;
			}
		}

		if ($constantName !== null && $classReflection->getNativeReflection()->hasConstant($constantName)) {
			$stub = $this->stubPhpDocProvider->findClassConstantPhpDoc($classReflection->getName(), $constantName);
			if ($stub !== null) {
				return $stub;
			}
		}

		return $this->fileTypeMapper->getResolvedPhpDoc(
			$phpDocBlock->getFile(),
			$classReflection->getName(),
			$traitName,
			$functionName,
			$phpDocBlock->getDocComment(),
		);
	}

}

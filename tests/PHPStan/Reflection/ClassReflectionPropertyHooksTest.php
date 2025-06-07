<?php declare(strict_types = 1);

namespace PHPStan\Reflection;

use PHPStan\Testing\PHPStanTestCase;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\VerbosityLevel;
use function count;
use const PHP_VERSION_ID;

class ClassReflectionPropertyHooksTest extends PHPStanTestCase
{

	protected function setUp(): void
	{
		if (PHP_VERSION_ID >= 80400) {
			return;
		}

		self::markTestSkipped('Test requires PHP 8.4');
	}

	public static function dataPropertyHooks(): iterable
	{
		$reflectionProvider = self::createReflectionProvider();

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\Foo'),
			'i',
			'set',
			['int'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\Foo'),
			'i',
			'get',
			[],
			'int',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\Foo'),
			'l',
			'get',
			[],
			'array<string>',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\Foo'),
			'n',
			'set',
			['array<string>|int'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooShort'),
			'i',
			'set',
			['int'],
			'void',
			false,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooShort'),
			'k',
			'set',
			['int|string'],
			'void',
			false,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooShort'),
			'l',
			'set',
			['array<string>'],
			'void',
			false,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooShort'),
			'm',
			'set',
			['array<string>'],
			'void',
			false,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooShort'),
			'n',
			'set',
			['array<string>|int'],
			'void',
			false,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructor'),
			'i',
			'set',
			['int'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructor'),
			'j',
			'set',
			['int'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructor'),
			'k',
			'set',
			['int|string'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructor'),
			'l',
			'set',
			['array<string>'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructor'),
			'l',
			'get',
			[],
			'array<string>',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructor'),
			'm',
			'set',
			['array<string>'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructor'),
			'n',
			'set',
			['array<string>|int'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructorWithParam'),
			'l',
			'set',
			['array<string>'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructorWithParam'),
			'l',
			'get',
			[],
			'array<string>',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooConstructorWithParam'),
			'm',
			'set',
			['array<string>'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooGenerics'),
			'm',
			'set',
			['array<T of stdClass (class PropertyHooksTypes\FooGenerics, parameter)>'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooGenerics'),
			'n',
			'set',
			['array<T of stdClass (class PropertyHooksTypes\FooGenerics, parameter)>|int'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooGenerics'),
			'm',
			'get',
			[],
			'array<T of stdClass (class PropertyHooksTypes\FooGenerics, parameter)>',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooGenerics'),
			'n',
			'get',
			[],
			'int',
			true,
		];

		$specificFooGenerics = (new GenericObjectType('PropertyHooksTypes\\FooGenerics', [new IntegerType()]))->getClassReflection();

		yield [
			$specificFooGenerics,
			'n',
			'set',
			['array<int>|int'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooGenerics'),
			'n',
			'get',
			[],
			'int',
			true,
		];

		yield [
			$specificFooGenerics,
			'm',
			'set',
			['array<int>'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooGenerics'),
			'm',
			'get',
			[],
			'array<T of stdClass (class PropertyHooksTypes\FooGenerics, parameter)>',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooGenericsConstructor'),
			'l',
			'set',
			['array<T of stdClass (class PropertyHooksTypes\FooGenericsConstructor, parameter)>'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooGenericsConstructor'),
			'm',
			'set',
			['array<T of stdClass (class PropertyHooksTypes\FooGenericsConstructor, parameter)>'],
			'void',
			true,
		];

		yield [
			$reflectionProvider->getClass('PropertyHooksTypes\\FooGenericsConstructor'),
			'n',
			'set',
			['array<T of stdClass (class PropertyHooksTypes\FooGenericsConstructor, parameter)>|int'],
			'void',
			true,
		];

		$specificFooGenericsConstructor = (new GenericObjectType('PropertyHooksTypes\\FooGenericsConstructor', [new IntegerType()]))->getClassReflection();

		yield [
			$specificFooGenericsConstructor,
			'n',
			'set',
			['array<int>|int'],
			'void',
			true,
		];

		yield [
			$specificFooGenericsConstructor,
			'm',
			'set',
			['array<int>'],
			'void',
			true,
		];

		yield [
			$specificFooGenericsConstructor,
			'm',
			'get',
			[],
			'array<int>',
			true,
		];
	}

	/**
	 * @dataProvider dataPropertyHooks
	 * @param ExtendedPropertyReflection::HOOK_* $hookName
	 * @param string[] $parameterTypes
	 */
	public function testPropertyHooks(
		ClassReflection $classReflection,
		string $propertyName,
		string $hookName,
		array $parameterTypes,
		string $returnType,
		bool $isVirtual,
	): void
	{
		$propertyReflection = $classReflection->getNativeProperty($propertyName);
		$this->assertSame($isVirtual, $propertyReflection->isVirtual()->yes());

		$hookReflection = $propertyReflection->getHook($hookName);
		$hookVariant = $hookReflection->getOnlyVariant();
		$this->assertSame($returnType, $hookVariant->getReturnType()->describe(VerbosityLevel::precise()));
		$this->assertCount(count($parameterTypes), $hookVariant->getParameters());

		foreach ($hookVariant->getParameters() as $i => $parameter) {
			$this->assertSame($parameterTypes[$i], $parameter->getType()->describe(VerbosityLevel::precise()));
		}
	}

}

<?php declare(strict_types = 1);

namespace PHPStan\Rules\InternalTag;

use PHPStan\Rules\RestrictedUsage\RestrictedClassConstantUsageRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<RestrictedClassConstantUsageRule>
 */
class RestrictedInternalClassConstantUsageExtensionTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return self::getContainer()->getByType(RestrictedClassConstantUsageRule::class);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/class-constant-internal-tag.php'], [
			[
				'Access to internal constant ClassConstantInternalTagOne\Foo::INTERNAL from outside its root namespace ClassConstantInternalTagOne.',
				49,
			],
			[
				'Access to constant FOO of internal class ClassConstantInternalTagOne\FooInternal from outside its root namespace ClassConstantInternalTagOne.',
				54,
			],
			[
				'Access to internal constant ClassConstantInternalTagOne\Foo::INTERNAL from outside its root namespace ClassConstantInternalTagOne.',
				62,
			],

			[
				'Access to constant FOO of internal class ClassConstantInternalTagOne\FooInternal from outside its root namespace ClassConstantInternalTagOne.',
				67,
			],
			[
				'Access to internal constant FooWithInternalClassConstantWithoutNamespace::INTERNAL.',
				89,
			],
			[
				'Access to constant FOO of internal class FooInternalWithClassConstantWithoutNamespace.',
				94,
			],
			[
				'Access to internal constant FooWithInternalClassConstantWithoutNamespace::INTERNAL.',
				102,
			],
			[
				'Access to constant FOO of internal class FooInternalWithClassConstantWithoutNamespace.',
				107,
			],
		]);
	}

	public function testStaticPropertyAccessOnInternalSubclass(): void
	{
		$this->analyse([__DIR__ . '/data/class-constant-access-on-internal-subclass.php'], [
			[
				'Access to constant BAR of internal class ClassConstantAccessOnInternalSubclassOne\Bar from outside its root namespace ClassConstantAccessOnInternalSubclassOne.',
				28,
			],
		]);
	}

}

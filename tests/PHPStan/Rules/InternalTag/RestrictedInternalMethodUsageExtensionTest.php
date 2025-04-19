<?php declare(strict_types = 1);

namespace PHPStan\Rules\InternalTag;

use PHPStan\Rules\RestrictedUsage\RestrictedMethodUsageRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<RestrictedMethodUsageRule>
 */
class RestrictedInternalMethodUsageExtensionTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return self::getContainer()->getByType(RestrictedMethodUsageRule::class);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/method-internal-tag.php'], [
			[
				'Call to internal method MethodInternalTagOne\Foo::doInternal() from outside its root namespace MethodInternalTagOne.',
				58,
			],
			[
				'Call to internal method MethodInternalTagOne\FooInternal::doFoo() from outside its root namespace MethodInternalTagOne.',
				63,
			],
			[
				'Call to internal method MethodInternalTagOne\Foo::doInternal() from outside its root namespace MethodInternalTagOne.',
				71,
			],

			[
				'Call to internal method MethodInternalTagOne\FooInternal::doFoo() from outside its root namespace MethodInternalTagOne.',
				76,
			],
			[
				'Call to internal method FooWithInternalMethodWithoutNamespace::doInternal().',
				107,
			],
			[
				'Call to internal method FooInternalWithoutNamespace::doFoo().',
				112,
			],
			[
				'Call to internal method FooWithInternalMethodWithoutNamespace::doInternal().',
				120,
			],
			[
				'Call to internal method FooInternalWithoutNamespace::doFoo().',
				125,
			],
		]);
	}

}

<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PHPStan\Php\PhpVersion;
use PHPStan\Rules\FunctionCallParametersCheck;
use PHPStan\Rules\NullsafeCheck;
use PHPStan\Rules\PhpDoc\UnresolvableTypeHelper;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;
use const PHP_VERSION_ID;

/**
 * @extends RuleTestCase<CallMethodsRule>
 */
class CallMethodsRuleTest extends RuleTestCase
{

	private bool $checkThisOnly;

	private bool $checkNullables;

	private bool $checkUnionTypes;

	private bool $checkExplicitMixed = false;

	private int $phpVersion = PHP_VERSION_ID;

	protected function getRule(): Rule
	{
		$reflectionProvider = $this->createReflectionProvider();
		$ruleLevelHelper = new RuleLevelHelper($reflectionProvider, $this->checkNullables, $this->checkThisOnly, $this->checkUnionTypes, $this->checkExplicitMixed);
		return new CallMethodsRule(
			new MethodCallCheck($reflectionProvider, $ruleLevelHelper, true, true),
			new FunctionCallParametersCheck($ruleLevelHelper, new NullsafeCheck(), new PhpVersion($this->phpVersion), new UnresolvableTypeHelper(), true, true, true, true),
		);
	}

	public function testCallMethods(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([ __DIR__ . '/data/call-methods.php'], [
			[
				'Call to an undefined method Test\Foo::protectedMethodFromChild().',
				10,
			],
			[
				'Call to an undefined method Test\Bar::loremipsum().',
				40,
			],
			[
				'Call to private method foo() of class Test\Foo.',
				41,
			],
			[
				'Method Test\Foo::foo() invoked with 1 parameter, 0 required.',
				41,
			],
			[
				'Method Test\Foo::test() invoked with 0 parameters, 1 required.',
				46,
			],
			[
				'Cannot call method method() on string.',
				49,
			],
			[
				'Call to method doFoo() on an unknown class Test\UnknownClass.',
				63,
				'Learn more at https://phpstan.org/user-guide/discovering-symbols',
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				66,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				68,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				70,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				72,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				75,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				76,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				77,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				78,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				79,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				81,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				83,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				84,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				85,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				86,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				90,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				91,
			],
			[
				'Call to an undefined method ArrayObject<int, stdClass>::doFoo().',
				108,
			],
			[
				'Method PDO::query() invoked with 0 parameters, 1-4 required.',
				113,
			],
			[
				'Parameter #1 $bar of method Test\ClassWithNullableProperty::doBar() is passed by reference, so it expects variables only.',
				167,
			],
			[
				'Parameter #1 $bar of method Test\ClassWithNullableProperty::doBar() is passed by reference, so it expects variables only.',
				168,
			],
			[
				'Cannot call method ipsum() on Test\Foo|null.',
				183,
			],
			[
				'Cannot call method ipsum() on Test\Bar|null.',
				184,
			],
			[
				'Cannot call method ipsum() on Test\Foo|null.',
				201,
			],
			[
				'Cannot call method ipsum() on Test\Bar|null.',
				202,
			],
			[
				'Method DateTimeZone::getTransitions() invoked with 3 parameters, 0-2 required.',
				214,
			],
			[
				'Result of method Test\ReturningSomethingFromConstructor::__construct() (void) is used.',
				234,
			],
			[
				'Cannot call method foo() on int|string.',
				254,
			],
			[
				'Method Test\FirstInterface::firstMethod() invoked with 1 parameter, 0 required.',
				281,
			],
			[
				'Method Test\SecondInterface::secondMethod() invoked with 1 parameter, 0 required.',
				282,
			],
			[
				'Cannot call method foo() on null.',
				299,
			],
			[
				'Call to method test() on an unknown class Test\FirstUnknownClass.',
				312,
				'Learn more at https://phpstan.org/user-guide/discovering-symbols',
			],
			[
				'Call to method test() on an unknown class Test\SecondUnknownClass.',
				312,
				'Learn more at https://phpstan.org/user-guide/discovering-symbols',
			],
			[
				'Cannot call method ipsum() on Test\Foo|null.',
				325,
			],
			[
				'Call to an undefined method Test\WithFooAndBarMethod|Test\WithFooMethod::bar().',
				355,
			],
			[
				'Call to an undefined method Test\SomeInterface&Test\WithFooMethod::bar().',
				372,
			],
			[
				'Method Test\Foo::test() invoked with 0 parameters, 1 required.',
				373,
			],
			[
				'Parameter #1 $foo of method Test\ObjectTypehint::doBar() expects Test\Foo, object given.',
				385,
			],
			[
				'Cannot call method test() on array<Test\UnknownClass>.',
				399,
			],
			[
				'Method Test\Foo::ipsum() invoked with 1 parameter, 0 required.',
				409,
			],
			[
				'Parameter #1 $test of method Test\NullableInPhpDoc::doFoo() expects string, null given.',
				427,
			],
			[
				'Parameter #1 $globalTitle of method Test\ThreeTypesCall::threeTypes() expects string, float given.',
				446,
			],
			[
				'Cannot call method find() on Test\NullCoalesce|null.',
				516,
			],
			[
				'Cannot call method find() on Test\NullCoalesce|null.',
				518,
			],
			[
				'Cannot call method find() on Test\NullCoalesce|null.',
				522,
			],
			[
				'Cannot call method find() on Test\NullCoalesce|null.',
				524,
			],
			[
				'Cannot call method find() on Test\NullCoalesce|null.',
				524,
			],
			[
				'Parameter #1 $param of method Test\IncompatiblePhpDocNullableTypeIssue::doFoo() expects string|null, int given.',
				551,
			],
			[
				'Parameter #1 $i of method Test\TernaryEvaluation::doBar() expects int, false given.',
				565,
			],
			[
				'Parameter #1 $i of method Test\TernaryEvaluation::doBar() expects int, Test\Foo given.',
				567,
			],
			[
				'Parameter #1 $i of method Test\TernaryEvaluation::doBar() expects int, false given.',
				568,
			],
			[
				'Parameter #1 $s of method Test\ForeachSituation::takesInt() expects int|null, string|null given.',
				595,
			],
			[
				'Parameter #1 $str of method Test\LiteralArrayTypeCheck::test() expects string, int given.',
				632,
			],
			[
				'Parameter #1 $str of method Test\LiteralArrayTypeCheck::test() expects string, true given.',
				633,
			],
			[
				'Cannot call method add() on null.',
				647,
			],
			[
				'Parameter #1 $str of method Test\CheckIsCallable::test() expects callable(): mixed, \'nonexistentFunction\' given.',
				658,
			],
			[
				'Parameter #1 $str of method Test\CheckIsCallable::test() expects callable(): mixed, \'Test…\' given.',
				660,
			],
			[
				'Method Test\VariadicAnnotationMethod::definedInPhpDoc() invoked with 0 parameters, at least 1 required.',
				714,
			],
			[
				'Parameter #2 $str of method Test\PreIncString::doFoo() expects string, int given.',
				725,
			],
			[
				'Cannot call method bar() on string.',
				747,
			],
			[
				'Cannot call method bar() on string.',
				748,
			],
			[
				'Parameter #1 $std of method Test\CheckDefaultArrayKeys::doAmet() expects stdClass, (int|string) given.',
				791,
			],
			[
				'Parameter #1 $i of method Test\CheckDefaultArrayKeys::doBar() expects int, int|stdClass|string given.',
				797,
			],
			[
				'Parameter #1 $str of method Test\CheckDefaultArrayKeys::doBaz() expects string, int|stdClass|string given.',
				798,
			],
			[
				'Parameter #1 $intOrString of method Test\CheckDefaultArrayKeys::doLorem() expects int|string, int|stdClass|string given.',
				799,
			],
			[
				'Parameter #1 $stdOrInt of method Test\CheckDefaultArrayKeys::doIpsum() expects int|stdClass, int|stdClass|string given.', // should not expect this
				800,
			],
			[
				'Parameter #1 $stdOrString of method Test\CheckDefaultArrayKeys::doDolor() expects stdClass|string, int|stdClass|string given.', // should not expect this
				801,
			],
			[
				'Parameter #1 $dateOrString of method Test\CheckDefaultArrayKeys::doSit() expects DateTimeImmutable|string, int|stdClass|string given.',
				802,
			],
			[
				'Parameter #1 $std of method Test\CheckDefaultArrayKeys::doAmet() expects stdClass, int|stdClass|string given.',
				803,
			],
			[
				'Parameter #1 $i of method Test\CheckDefaultArrayKeys::doBar() expects int, int|string given.',
				866,
			],
			[
				'Parameter #1 $str of method Test\CheckDefaultArrayKeys::doBaz() expects string, int|string given.',
				867,
			],
			[
				'Cannot call method test() on string.',
				885,
			],
			[
				'Method Test\Foo::test() invoked with 0 parameters, 1 required.',
				886,
			],
			[
				'Call to an undefined method ReflectionType::getName().',
				896,
			],
			[
				'Call to an undefined method ReflectionType::getName().',
				897,
			],
			[
				'Call to an undefined method Test\Foo::lorem().',
				907,
			],
			[
				'Call to an undefined method Test\Foo::lorem().',
				911,
			],
			[
				'Cannot call method foo() on class-string|object.',
				914,
			],
			[
				'Parameter #1 $callable of method Test\\MethodExists::doBar() expects callable(): mixed, array{class-string|object, \'foo\'} given.',
				915,
			],
			[
				'Parameter #1 $callable of method Test\\MethodExists::doBar() expects callable(): mixed, array{class-string|object, \'bar\'} given.',
				916,
			],
			[
				'Parameter #1 $callable of method Test\\MethodExists::doBar() expects callable(): mixed, array{object, \'bar\'} given.',
				921,
			],
			[
				'Parameter #1 $namespaceOrPrefix of method SimpleXMLElement::children() expects string|null, int given.',
				942,
			],
			[
				'Parameter #1 $s of method Test\IssetCumulativeArray::doBar() expects string, int given.',
				964,
			],
			[
				'Parameter #1 $s of method Test\IssetCumulativeArray::doBar() expects string, int given.',
				987,
			],
			[
				'Parameter #1 $s of method Test\IssetCumulativeArray::doBar() expects string, int given.',
				1005,
			],
			[
				'Call to an undefined method Test\CallAfterPropertyEmpty::doBar().',
				1072,
			],
			[
				'Call to an undefined method Test\ArraySliceWithNonEmptyArray::doesNotExist().',
				1092,
			],
			[
				'Call to an undefined method Test\AssertInFor::doBar().',
				1207,
			],
			[
				'Parameter #1 $i of method Test\SubtractedMixed::requireInt() expects int, mixed given.',
				1277,
			],
			[
				'Parameter #1 $i of method Test\SubtractedMixed::requireInt() expects int, mixed given.',
				1284,
			],
			[
				'Parameter #1 $parameter of method Test\SubtractedMixed::requireIntOrString() expects int|string, mixed given.',
				1285,
			],
			[
				'Parameter #2 $b of method Test\ExpectsExceptionGenerics::expectsExceptionUpperBound() expects Exception, Throwable given.',
				1378,
			],
			[
				'Parameter #1 $foo of method Test\ExpectsExceptionGenerics::requiresFoo() expects Test\Foo, Exception given.',
				1379,
			],
			[
				'Only iterables can be unpacked, array<int>|null given in argument #5.',
				1459,
			],
			[
				'Only iterables can be unpacked, int given in argument #6.',
				1460,
			],
			[
				'Only iterables can be unpacked, string given in argument #7.',
				1461,
			],
			[
				'Parameter #1 $s of method Test\ClassStringWithUpperBounds::doFoo() expects class-string<Exception>, string given.',
				1490,
			],
			[
				'Parameter #2 $object of method Test\ClassStringWithUpperBounds::doFoo() expects Exception, Throwable given.',
				1490,
			],
			[
				'Unable to resolve the template type T in call to method Test\ClassStringWithUpperBounds::doFoo()',
				1490,
				'See: https://phpstan.org/blog/solving-phpstan-error-unable-to-resolve-template-type',
			],
			[
				'Parameter #1 $a of method Test\\CallableWithMixedArray::doBar() expects callable(array<string>): array<string>, Closure(array): array{\'foo\'}|null given.',
				1533,
			],
			[
				'Parameter #1 $members of method Test\\ParameterTypeCheckVerbosity::doBar() expects array<array{id: string, code: string}>, array<array{code: string}> given.',
				1589,
			],
			[
				'Parameter #1 $test of method Test\NumericStringParam::sayHello() expects numeric-string, 123 given.',
				1657,
			],
			[
				'Parameter #1 $test of method Test\NumericStringParam::sayHello() expects numeric-string, \'abc\' given.',
				1658,
			],
			[
				'Parameter #1 $date of method Test\HelloWorld3::sayHello() expects array<DateTime|DateTimeImmutable>|int, DateTimeInterface given.',
				1732,
			],
			[
				'Parameter #1 $a of method Test\InvalidReturnTypeUsingArrayTemplateTypeBound::bar() expects array<string>, array<int, int> given.',
				1751,
			],
			[
				'Unable to resolve the template type T in call to method Test\InvalidReturnTypeUsingArrayTemplateTypeBound::bar()',
				1751,
				'See: https://phpstan.org/blog/solving-phpstan-error-unable-to-resolve-template-type',
			],
			[
				'Parameter #1 $code of method Test\\KeyOfParam::foo() expects \'jfk\'|\'lga\', \'sfo\' given.',
				1777,
			],
			[
				'Parameter #1 $code of method Test\\ValueOfParam::foo() expects \'John F. Kennedy…\'|\'La Guardia Airport\', \'Newark Liberty…\' given.',
				1802,
			],
		]);
	}

	public function testCallMethodsOnThisOnly(): void
	{
		$this->checkThisOnly = true;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([ __DIR__ . '/data/call-methods.php'], [
			[
				'Call to an undefined method Test\Foo::protectedMethodFromChild().',
				10,
			],
			[
				'Call to an undefined method Test\Bar::loremipsum().',
				40,
			],
			[
				'Call to private method foo() of class Test\Foo.',
				41,
			],
			[
				'Method Test\Foo::foo() invoked with 1 parameter, 0 required.',
				41,
			],
			[
				'Method Test\Foo::test() invoked with 0 parameters, 1 required.',
				46,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				66,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				68,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				70,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				72,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				75,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				76,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				77,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				78,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				79,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				81,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				83,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				84,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				85,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				86,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				90,
			],
			[
				'Result of method Test\Bar::returnsVoid() (void) is used.',
				91,
			],
			[
				'Parameter #1 $bar of method Test\ClassWithNullableProperty::doBar() is passed by reference, so it expects variables only.',
				167,
			],
			[
				'Parameter #1 $bar of method Test\ClassWithNullableProperty::doBar() is passed by reference, so it expects variables only.',
				168,
			],
			[
				'Parameter #1 $foo of method Test\ObjectTypehint::doBar() expects Test\Foo, object given.',
				385,
			],
			[
				'Parameter #1 $test of method Test\NullableInPhpDoc::doFoo() expects string, null given.',
				427,
			],
			[
				'Parameter #1 $globalTitle of method Test\ThreeTypesCall::threeTypes() expects string, float given.',
				446,
			],
			[
				'Parameter #1 $param of method Test\IncompatiblePhpDocNullableTypeIssue::doFoo() expects string|null, int given.',
				551,
			],
			[
				'Parameter #1 $i of method Test\TernaryEvaluation::doBar() expects int, false given.',
				565,
			],
			[
				'Parameter #1 $i of method Test\TernaryEvaluation::doBar() expects int, Test\Foo given.',
				567,
			],
			[
				'Parameter #1 $i of method Test\TernaryEvaluation::doBar() expects int, false given.',
				568,
			],
			[
				'Parameter #1 $s of method Test\ForeachSituation::takesInt() expects int|null, string|null given.',
				595,
			],
			[
				'Parameter #1 $str of method Test\LiteralArrayTypeCheck::test() expects string, int given.',
				632,
			],
			[
				'Parameter #1 $str of method Test\LiteralArrayTypeCheck::test() expects string, true given.',
				633,
			],
			[
				'Parameter #1 $str of method Test\CheckIsCallable::test() expects callable(): mixed, \'nonexistentFunction\' given.',
				658,
			],
			[
				'Parameter #1 $str of method Test\CheckIsCallable::test() expects callable(): mixed, \'Test…\' given.',
				660,
			],
			[
				'Method Test\VariadicAnnotationMethod::definedInPhpDoc() invoked with 0 parameters, at least 1 required.',
				714,
			],
			[
				'Parameter #2 $str of method Test\PreIncString::doFoo() expects string, int given.',
				725,
			],
			[
				'Parameter #1 $std of method Test\CheckDefaultArrayKeys::doAmet() expects stdClass, (int|string) given.',
				791,
			],
			[
				'Parameter #1 $i of method Test\CheckDefaultArrayKeys::doBar() expects int, int|stdClass|string given.',
				797,
			],
			[
				'Parameter #1 $str of method Test\CheckDefaultArrayKeys::doBaz() expects string, int|stdClass|string given.',
				798,
			],
			[
				'Parameter #1 $intOrString of method Test\CheckDefaultArrayKeys::doLorem() expects int|string, int|stdClass|string given.',
				799,
			],
			[
				'Parameter #1 $stdOrInt of method Test\CheckDefaultArrayKeys::doIpsum() expects int|stdClass, int|stdClass|string given.', // should not expect this
				800,
			],
			[
				'Parameter #1 $stdOrString of method Test\CheckDefaultArrayKeys::doDolor() expects stdClass|string, int|stdClass|string given.', // should not expect this
				801,
			],
			[
				'Parameter #1 $dateOrString of method Test\CheckDefaultArrayKeys::doSit() expects DateTimeImmutable|string, int|stdClass|string given.',
				802,
			],
			[
				'Parameter #1 $std of method Test\CheckDefaultArrayKeys::doAmet() expects stdClass, int|stdClass|string given.',
				803,
			],
			[
				'Parameter #1 $i of method Test\CheckDefaultArrayKeys::doBar() expects int, int|string given.',
				866,
			],
			[
				'Parameter #1 $str of method Test\CheckDefaultArrayKeys::doBaz() expects string, int|string given.',
				867,
			],
			[
				'Parameter #1 $callable of method Test\\MethodExists::doBar() expects callable(): mixed, array{class-string|object, \'foo\'} given.',
				915,
			],
			[
				'Parameter #1 $callable of method Test\\MethodExists::doBar() expects callable(): mixed, array{class-string|object, \'bar\'} given.',
				916,
			],
			[
				'Parameter #1 $callable of method Test\\MethodExists::doBar() expects callable(): mixed, array{object, \'bar\'} given.',
				921,
			],
			[
				'Parameter #1 $s of method Test\IssetCumulativeArray::doBar() expects string, int given.',
				964,
			],
			[
				'Parameter #1 $s of method Test\IssetCumulativeArray::doBar() expects string, int given.',
				987,
			],
			[
				'Parameter #1 $s of method Test\IssetCumulativeArray::doBar() expects string, int given.',
				1005,
			],
			[
				'Call to an undefined method Test\CallAfterPropertyEmpty::doBar().',
				1072,
			],
			[
				'Parameter #1 $i of method Test\SubtractedMixed::requireInt() expects int, mixed given.',
				1277,
			],
			[
				'Parameter #1 $i of method Test\SubtractedMixed::requireInt() expects int, mixed given.',
				1284,
			],
			[
				'Parameter #1 $parameter of method Test\SubtractedMixed::requireIntOrString() expects int|string, mixed given.',
				1285,
			],
			[
				'Parameter #2 $b of method Test\ExpectsExceptionGenerics::expectsExceptionUpperBound() expects Exception, Throwable given.',
				1378,
			],
			[
				'Parameter #1 $foo of method Test\ExpectsExceptionGenerics::requiresFoo() expects Test\Foo, Exception given.',
				1379,
			],
			[
				'Parameter #1 $s of method Test\ClassStringWithUpperBounds::doFoo() expects class-string<Exception>, string given.',
				1490,
			],
			[
				'Parameter #2 $object of method Test\ClassStringWithUpperBounds::doFoo() expects Exception, Throwable given.',
				1490,
			],
			[
				'Unable to resolve the template type T in call to method Test\ClassStringWithUpperBounds::doFoo()',
				1490,
				'See: https://phpstan.org/blog/solving-phpstan-error-unable-to-resolve-template-type',
			],
			[
				'Parameter #1 $a of method Test\\CallableWithMixedArray::doBar() expects callable(array<string>): array<string>, Closure(array): array{\'foo\'}|null given.',
				1533,
			],
			[
				'Parameter #1 $members of method Test\\ParameterTypeCheckVerbosity::doBar() expects array<array{id: string, code: string}>, array<array{code: string}> given.',
				1589,
			],
			[
				'Parameter #1 $test of method Test\NumericStringParam::sayHello() expects numeric-string, 123 given.',
				1657,
			],
			[
				'Parameter #1 $test of method Test\NumericStringParam::sayHello() expects numeric-string, \'abc\' given.',
				1658,
			],
			[
				'Parameter #1 $date of method Test\HelloWorld3::sayHello() expects array<DateTime|DateTimeImmutable>|int, DateTimeInterface given.',
				1732,
			],
			[
				'Parameter #1 $a of method Test\InvalidReturnTypeUsingArrayTemplateTypeBound::bar() expects array<string>, array<int, int> given.',
				1751,
			],
			[
				'Unable to resolve the template type T in call to method Test\InvalidReturnTypeUsingArrayTemplateTypeBound::bar()',
				1751,
				'See: https://phpstan.org/blog/solving-phpstan-error-unable-to-resolve-template-type',
			],
			[
				'Parameter #1 $code of method Test\\KeyOfParam::foo() expects \'jfk\'|\'lga\', \'sfo\' given.',
				1777,
			],
			[
				'Parameter #1 $code of method Test\\ValueOfParam::foo() expects \'John F. Kennedy…\'|\'La Guardia Airport\', \'Newark Liberty…\' given.',
				1802,
			],
		]);
	}

	public function testCallTraitMethods(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/call-trait-methods.php'], [
			[
				'Call to an undefined method CallTraitMethods\Baz::unexistentMethod().',
				26,
			],
		]);
	}

	public function testCallTraitOverridenMethods(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/call-trait-overridden-methods.php'], []);
	}

	public function testCallInterfaceMethods(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/call-interface-methods.php'], [
			[
				'Call to an undefined method InterfaceMethods\Baz::barMethod().',
				25,
			],
		]);
	}

	public function testClosureBind(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/closure-bind.php'], [
			[
				'Call to an undefined method CallClosureBind\Foo::nonexistentMethod().',
				12,
			],
			[
				'Call to an undefined method CallClosureBind\Bar::barMethod().',
				16,
			],
			[
				'Call to private method privateMethod() of class CallClosureBind\Foo.',
				18,
			],
			[
				'Call to an undefined method CallClosureBind\Foo::nonexistentMethod().',
				19,
			],
			[
				'Call to an undefined method CallClosureBind\Bar::barMethod().',
				23,
			],
			[
				'Call to an undefined method CallClosureBind\Foo::nonexistentMethod().',
				28,
			],
			[
				'Call to an undefined method CallClosureBind\Foo::nonexistentMethod().',
				33,
			],
			[
				'Call to an undefined method CallClosureBind\Foo::nonexistentMethod().',
				39,
			],
		]);
	}

	public function testArrowFunctionClosureBind(): void
	{
		if (!self::$useStaticReflectionProvider && PHP_VERSION_ID < 70400) {
			$this->markTestSkipped('Test requires PHP 7.4.');
		}
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/arrow-function-bind.php'], [
			[
				'Call to an undefined method CallArrowFunctionBind\Foo::nonexistentMethod().',
				27,
			],
			[
				'Call to an undefined method CallArrowFunctionBind\Bar::barMethod().',
				29,
			],
			[
				'Call to an undefined method CallArrowFunctionBind\Foo::nonexistentMethod().',
				31,
			],
			[
				'Call to an undefined method CallArrowFunctionBind\Foo::nonexistentMethod().',
				33,
			],
			[
				'Call to an undefined method CallArrowFunctionBind\Foo::nonexistentMethod().',
				35,
			],
		]);
	}

	public function testCallVariadicMethods(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/call-variadic-methods.php'], [
			[
				'Method CallVariadicMethods\Foo::baz() invoked with 0 parameters, at least 1 required.',
				10,
			],
			[
				'Method CallVariadicMethods\Foo::lorem() invoked with 0 parameters, at least 2 required.',
				11,
			],
			[
				'Parameter #2 ...$strings of method CallVariadicMethods\Foo::doVariadicString() expects string, int given.',
				32,
			],
			[
				'Parameter #3 ...$strings of method CallVariadicMethods\Foo::doVariadicString() expects string, int given.',
				32,
			],
			[
				'Parameter #1 $int of method CallVariadicMethods\Foo::doVariadicString() expects int, string given.',
				34,
			],
			[
				'Parameter #3 ...$strings of method CallVariadicMethods\Foo::doVariadicString() expects string, int given.',
				42,
			],
			[
				'Parameter #4 ...$strings of method CallVariadicMethods\Foo::doVariadicString() expects string, int given.',
				42,
			],
			[
				'Parameter #5 ...$strings of method CallVariadicMethods\Foo::doVariadicString() expects string, int given.',
				42,
			],
			[
				'Parameter #6 ...$strings of method CallVariadicMethods\Foo::doVariadicString() expects string, int given.',
				42,
			],
			[
				'Method CallVariadicMethods\Foo::doIntegerParameters() invoked with 3 parameters, 2 required.',
				43,
			],
			[
				'Parameter #1 $foo of method CallVariadicMethods\Foo::doIntegerParameters() expects int, string given.',
				43,
			],
			[
				'Parameter #2 $bar of method CallVariadicMethods\Foo::doIntegerParameters() expects int, string given.',
				43,
			],
			[
				'Method CallVariadicMethods\Foo::doIntegerParameters() invoked with 3 parameters, 2 required.',
				44,
			],
			[
				'Parameter #1 ...$strings of method CallVariadicMethods\Bar::variadicStrings() expects string, int given.',
				85,
			],
			[
				'Parameter #2 ...$strings of method CallVariadicMethods\Bar::variadicStrings() expects string, int given.',
				85,
			],
			[
				'Parameter #1 ...$strings of method CallVariadicMethods\Bar::anotherVariadicStrings() expects string, int given.',
				88,
			],
			[
				'Parameter #2 ...$strings of method CallVariadicMethods\Bar::anotherVariadicStrings() expects string, int given.',
				88,
			],
		]);
	}

	public function testCallToIncorrectCaseMethodName(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/incorrect-method-case.php'], [
			[
				'Call to method IncorrectMethodCase\Foo::fooBar() with incorrect case: foobar',
				10,
			],
		]);
	}

	public function testNullableParameters(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/nullable-parameters.php'], [
			[
				'Method NullableParameters\Foo::doFoo() invoked with 0 parameters, 2 required.',
				6,
			],
			[
				'Method NullableParameters\Foo::doFoo() invoked with 1 parameter, 2 required.',
				7,
			],
			[
				'Method NullableParameters\Foo::doFoo() invoked with 3 parameters, 2 required.',
				10,
			],
		]);
	}

	public function testProtectedMethodCallFromParent(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/protected-method-call-from-parent.php'], []);
	}

	public function testSiblingMethodPrototype(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/sibling-method-prototype.php'], []);
	}

	public function testOverridenMethodPrototype(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/overriden-method-prototype.php'], []);
	}

	public function testCallMethodWithInheritDoc(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/calling-method-with-inheritdoc.php'], [
			[
				'Parameter #1 $i of method MethodWithInheritDoc\Baz::doFoo() expects int, string given.',
				65,
			],
			[
				'Parameter #1 $str of method MethodWithInheritDoc\Foo::doBar() expects string, int given.',
				67,
			],
		]);
	}

	public function testCallMethodWithInheritDocWithoutCurlyBraces(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/calling-method-with-inheritdoc-without-curly-braces.php'], [
			[
				'Parameter #1 $i of method MethodWithInheritDocWithoutCurlyBraces\Baz::doFoo() expects int, string given.',
				65,
			],
			[
				'Parameter #1 $str of method MethodWithInheritDocWithoutCurlyBraces\Foo::doBar() expects string, int given.',
				67,
			],
		]);
	}

	public function testCallMethodWithPhpDocsImplicitInheritance(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/calling-method-with-phpDocs-implicit-inheritance.php'], [
			[
				'Parameter #1 $i of method MethodWithPhpDocsImplicitInheritance\Baz::doFoo() expects int, string given.',
				56,
			],
			[
				'Parameter #1 $str of method MethodWithPhpDocsImplicitInheritance\Foo::doBar() expects string, int given.',
				58,
			],
			[
				'Parameter #1 $x of method MethodWithPhpDocsImplicitInheritance\Ipsum::doLorem() expects MethodWithPhpDocsImplicitInheritance\A, int given.',
				89,
			],
			[
				'Parameter #2 $y of method MethodWithPhpDocsImplicitInheritance\Ipsum::doLorem() expects MethodWithPhpDocsImplicitInheritance\B, int given.',
				89,
			],
			[
				'Parameter #3 $z of method MethodWithPhpDocsImplicitInheritance\Ipsum::doLorem() expects MethodWithPhpDocsImplicitInheritance\C, int given.',
				89,
			],
			[
				'Parameter #4 $d of method MethodWithPhpDocsImplicitInheritance\Ipsum::doLorem() expects MethodWithPhpDocsImplicitInheritance\D, int given.',
				89,
			],
			[
				'Parameter #1 $g of method MethodWithPhpDocsImplicitInheritance\Dolor::doLorem() expects MethodWithPhpDocsImplicitInheritance\A, int given.',
				104,
			],
			[
				'Parameter #2 $h of method MethodWithPhpDocsImplicitInheritance\Dolor::doLorem() expects MethodWithPhpDocsImplicitInheritance\B, int given.',
				104,
			],
			[
				'Parameter #3 $i of method MethodWithPhpDocsImplicitInheritance\Dolor::doLorem() expects MethodWithPhpDocsImplicitInheritance\C, int given.',
				104,
			],
			[
				'Parameter #4 $d of method MethodWithPhpDocsImplicitInheritance\Dolor::doLorem() expects MethodWithPhpDocsImplicitInheritance\D, int given.',
				104,
			],
			[
				'Parameter #1 $value of method ArrayObject<int,stdClass>::append() expects stdClass, Exception given.',
				115,
			],
			[
				'Parameter #1 $value of method ArrayObject<int,stdClass>::append() expects stdClass, Exception given.',
				129,
			],
			[
				'Parameter #1 $someValue of method MethodWithPhpDocsImplicitInheritance\TestArrayObject3::append() expects stdClass, Exception given.',
				146,
			],
		]);
	}

	public function testNegatedInstanceof(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/negated-instanceof.php'], []);
	}

	public function testInvokeMagicInvokeMethod(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/invoke-magic-method.php'], [
			[
				'Parameter #1 $foo of method InvokeMagicInvokeMethod\ClassForCallable::doFoo() expects callable(): mixed, InvokeMagicInvokeMethod\ClassForCallable given.',
				27,
			],
		]);
	}

	public function testCheckNullables(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/check-nullables.php'], [
			[
				'Parameter #1 $foo of method CheckNullables\Foo::doFoo() expects string, null given.',
				11,
			],
			[
				'Parameter #1 $foo of method CheckNullables\Foo::doFoo() expects string, string|null given.',
				15,
			],
		]);
	}

	public function testDoNotCheckNullables(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = false;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/check-nullables.php'], [
			[
				'Parameter #1 $foo of method CheckNullables\Foo::doFoo() expects string, null given.',
				11,
			],
		]);
	}

	public function testMysqliQuery(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = false;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/mysqli-query.php'], [
			[
				'Method mysqli::query() invoked with 0 parameters, 1-2 required.',
				4,
			],
		]);
	}

	public function testCallMethodsNullIssue(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = false;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/order.php'], []);
	}

	public function dataIterable(): array
	{
		return [
			[
				true,
			],
			[
				false,
			],
		];
	}

	/**
	 * @dataProvider dataIterable
	 */
	public function testIterables(bool $checkNullables): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = $checkNullables;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/call-methods-iterable.php'], [
			[
				'Parameter #1 $ids of method CallMethodsIterables\Uuid::bar() expects iterable<CallMethodsIterables\Uuid>, array<int, null> given.',
				14,
			],
			[
				'Parameter #1 $iterable of method CallMethodsIterables\Foo::acceptsSelfIterable() expects iterable<CallMethodsIterables\Foo>, iterable<CallMethodsIterables\Bar> given.',
				59,
			],
			[
				'Parameter #1 $iterable of method CallMethodsIterables\Foo::acceptsSelfIterable() expects iterable<CallMethodsIterables\Foo>, string given.',
				60,
			],
			[
				'Parameter #1 $iterableWithoutTypehint of method CallMethodsIterables\Foo::doFoo() expects iterable, int given.',
				62,
			],
			[
				'Parameter #2 $iterableWithIterableTypehint of method CallMethodsIterables\Foo::doFoo() expects iterable, int given.',
				62,
			],
			[
				'Parameter #3 $iterableWithConcreteTypehint of method CallMethodsIterables\Foo::doFoo() expects iterable<CallMethodsIterables\Bar>, int given.',
				62,
			],
			[
				'Parameter #4 $arrayWithIterableTypehint of method CallMethodsIterables\Foo::doFoo() expects array, int given.',
				62,
			],
			[
				'Parameter #5 $unionIterableType of method CallMethodsIterables\Foo::doFoo() expects CallMethodsIterables\Collection&iterable<CallMethodsIterables\Bar>, int given.',
				62,
			],
			[
				'Parameter #6 $mixedUnionIterableType of method CallMethodsIterables\Foo::doFoo() expects array, int given.',
				62,
			],
			[
				'Parameter #7 $unionIterableIterableType of method CallMethodsIterables\Foo::doFoo() expects CallMethodsIterables\Collection&iterable<CallMethodsIterables\Bar>, int given.',
				62,
			],
			[
				'Parameter #9 $integers of method CallMethodsIterables\Foo::doFoo() expects iterable<int>, int given.',
				62,
			],
			[
				'Parameter #10 $mixeds of method CallMethodsIterables\Foo::doFoo() expects iterable, int given.',
				62,
			],
		]);
	}

	public function testAcceptThrowable(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/accept-throwable.php'], [
			[
				'Parameter #1 $i of method AcceptThrowable\Foo::doBar() expects int, AcceptThrowable\SomeInterface&Throwable given.',
				41,
			],
			[
				'Parameter #1 $i of method AcceptThrowable\Foo::doBar() expects int, AcceptThrowable\InterfaceExtendingThrowable given.',
				44,
			],
			[
				'Parameter #1 $i of method AcceptThrowable\Foo::doBar() expects int, AcceptThrowable\NonExceptionClass&Throwable given.',
				47,
			],
			[
				'Parameter #1 $i of method AcceptThrowable\Foo::doBar() expects int, Exception given.',
				50,
			],
		]);
	}

	public function testWithoutCheckUnionTypes(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = false;
		$this->analyse([__DIR__ . '/data/without-union-types.php'], [
			[
				'Method CallMethodsWithoutUnionTypes\Foo::doFoo() invoked with 3 parameters, 0 required.',
				14,
			],
		]);
	}

	public function testStrictTypes(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/call-methods-strict.php'], [
			[
				'Parameter #1 $foo of method Test\ClassWithToString::acceptsString() expects string, Test\ClassWithToString given.',
				7,
			],
		]);
	}

	public function testAliasedTraitsProblem(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/aliased-traits-problem.php'], []);
	}

	public function testClosureCallInvocations(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/closure-call.php'], [
			[
				'Method Closure::call() invoked with 0 parameters, 2 required.',
				9,
			],
			[
				'Method Closure::call() invoked with 1 parameter, 2 required.',
				10,
			],
			[
				'Method Closure::call() invoked with 1 parameter, 2 required.',
				11,
			],
			[
				'Parameter #1 $newThis of method Closure::call() expects object, int given.',
				11,
			],
			[
				'Parameter #2 $thing of method Closure::call() expects object, int given.',
				12,
			],
			[
				'Parameter #1 $newThis of method Closure::call() expects object, int given.',
				13,
			],
			[
				'Method Closure::call() invoked with 3 parameters, 2 required.',
				14,
			],
			[
				'Result of method Closure::call() (void) is used.',
				18,
			],
		]);
	}

	public function testMixin(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/mixin.php'], [
			[
				'Method MixinMethods\Foo::doFoo() invoked with 1 parameter, 0 required.',
				30,
			],
			[
				'Method MixinMethods\Foo::doFoo() invoked with 1 parameter, 0 required.',
				40,
			],
			[
				'Method Exception::getMessage() invoked with 1 parameter, 0 required.',
				61,
			],
			[
				'Call to an undefined method MixinMethods\GenericFoo<Exception>::getMessagee().',
				62,
			],
		]);
	}

	public function testRecursiveIteratorIterator(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/recursive-iterator-iterator.php'], [
			[
				'Method RecursiveDirectoryIterator::getSubPathname() invoked with 1 parameter, 0 required.',
				14,
			],
		]);
	}

	public function testMergeInheritedPhpDocs(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/merge-inherited-param.php'], [
			[
				'Parameter #1 $uno of method CallMethodsPhpDocMergeParamInherited\ParentClass::method() expects CallMethodsPhpDocMergeParamInherited\A, CallMethodsPhpDocMergeParamInherited\D given.',
				37,
			],
			[
				'Parameter #2 $dos of method CallMethodsPhpDocMergeParamInherited\ParentClass::method() expects CallMethodsPhpDocMergeParamInherited\B, CallMethodsPhpDocMergeParamInherited\D given.',
				37,
			],
			[
				'Parameter #1 $one of method CallMethodsPhpDocMergeParamInherited\ChildClass::method() expects CallMethodsPhpDocMergeParamInherited\C, CallMethodsPhpDocMergeParamInherited\B given.',
				42,
			],
			[
				'Parameter #2 $two of method CallMethodsPhpDocMergeParamInherited\ChildClass::method() expects CallMethodsPhpDocMergeParamInherited\B, CallMethodsPhpDocMergeParamInherited\D given.',
				42,
			],
		]);
	}

	public function testShadowedTraitMethod(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/shadowed-trait-method.php'], []);
	}

	public function dataExplicitMixed(): array
	{
		return [
			[
				true,
				[
					[
						'Cannot call method foo() on mixed.',
						17,
					],
					[
						'Parameter #1 $i of method CheckExplicitMixedMethodCall\Bar::doBar() expects int, mixed given.',
						43,
					],
					[
						'Parameter #1 $i of method CheckExplicitMixedMethodCall\Bar::doBar() expects int, T given.',
						65,
					],
					[
						'Parameter #1 $cb of method CheckExplicitMixedMethodCall\CallableMixed::doFoo() expects callable(mixed): void, Closure(int): void given.',
						133,
					],
					[
						'Parameter #1 $cb of method CheckExplicitMixedMethodCall\CallableMixed::doBar2() expects callable(): int, Closure(): mixed given.',
						152,
					],
				],
			],
			[
				false,
				[],
			],
		];
	}

	/**
	 * @dataProvider dataExplicitMixed
	 * @param mixed[] $errors
	 */
	public function testExplicitMixed(bool $checkExplicitMixed, array $errors): void
	{
		if (PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires PHP 8.0.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->checkExplicitMixed = $checkExplicitMixed;
		$this->analyse([__DIR__ . '/data/check-explicit-mixed.php'], $errors);
	}

	public function testBug3409(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3409.php'], []);
	}

	public function testBug2600(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-2600.php'], [
			[
				'Method Bug2600\Foo::doBar() invoked with 3 parameters, 0-1 required.',
				10,
			],
		]);
	}

	public function testBug3415(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3415.php'], []);
	}

	public function testBug3415Two(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3415-2.php'], []);
	}

	public function testBug3445(): void
	{
		if (!self::$useStaticReflectionProvider) {
			if (PHP_VERSION_ID < 70300) {
				$this->markTestSkipped('PHP looks at the parameter value non-lazily before PHP 7.3.');
			}
		}
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3445.php'], [
			[
				'Parameter #1 $test of method Bug3445\Foo::doFoo() expects Bug3445\Foo, $this(Bug3445\Bar) given.',
				26,
			],
		]);
	}

	public function testBug3481(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3481.php'], [
			[
				'Method Bug3481\Foo::doSomething() invoked with 2 parameters, 3 required.',
				34,
			],
			[
				'Parameter #1 $a of method Bug3481\Foo::doSomething() expects string, int|string given.',
				44,
			],
		]);
	}

	public function testBug3683(): void
	{
		if (self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires hybrid reflection.');
		}
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3683.php'], [
			[
				'Parameter #1 $exception of method Generator<mixed,mixed,mixed,mixed>::throw() expects Throwable, int given.',
				7,
			],
		]);
	}

	public function testStringable(): void
	{
		if (PHP_VERSION_ID < 80000) {
			$this->markTestSkipped('Test requires PHP 8.0.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/stringable.php'], []);
	}

	public function testStringableStrictTypes(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/stringable-strict.php'], [
			[
				'Parameter #1 $s of method TestStringables\Dolor::doFoo() expects string, TestStringables\Bar given.',
				15,
			],
		]);
	}

	public function testMatchExpressionVoidIsUsed(): void
	{
		if (PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires PHP 8.0.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/match-expr-void-used.php'], [
			[
				'Result of method MatchExprVoidUsed\Foo::doLorem() (void) is used.',
				10,
			],
			[
				'Result of method MatchExprVoidUsed\Foo::doBar() (void) is used.',
				11,
			],
		]);
	}

	public function testNullSafe(): void
	{
		if (PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires PHP 8.0.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;

		$this->analyse([__DIR__ . '/data/nullsafe-method-call.php'], [
			[
				'Method NullsafeMethodCall\Foo::doBar() invoked with 1 parameter, 0 required.',
				11,
			],
			[
				'Parameter #1 $passedByRef of method NullsafeMethodCall\Foo::doBaz() is passed by reference, so it expects variables only.',
				26,
			],
			[
				'Parameter #1 $passedByRef of method NullsafeMethodCall\Foo::doBaz() is passed by reference, so it expects variables only.',
				27,
			],
		]);
	}

	public function testDisallowNamedArguments(): void
	{
		if (PHP_VERSION_ID >= 80000) {
			$this->markTestSkipped('Test requires PHP earlier than 8.0.');
		}
		if (!self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires static reflection.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;

		$this->analyse([__DIR__ . '/data/disallow-named-arguments.php'], [
			[
				'Named arguments are supported only on PHP 8.0 and later.',
				10,
			],
		]);
	}

	public function testNamedArguments(): void
	{
		if (!self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires static reflection.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->phpVersion = 80000;

		$this->analyse([__DIR__ . '/data/named-arguments.php'], [
			[
				'Named argument cannot be followed by a positional argument.',
				21,
			],
			[
				'Named argument cannot be followed by a positional argument.',
				22,
			],
			[
				'Missing parameter $j (int) in call to method NamedArgumentsMethod\Foo::doFoo().',
				19,
			],
			[
				'Missing parameter $k (int) in call to method NamedArgumentsMethod\Foo::doFoo().',
				19,
			],
			[
				'Argument for parameter $i has already been passed.',
				26,
			],
			[
				'Argument for parameter $i has already been passed.',
				32,
			],
			[
				'Missing parameter $k (int) in call to method NamedArgumentsMethod\Foo::doFoo().',
				37,
			],
			[
				'Unknown parameter $z in call to method NamedArgumentsMethod\Foo::doFoo().',
				46,
			],
			[
				'Parameter #1 $i of method NamedArgumentsMethod\Foo::doFoo() expects int, string given.',
				50,
			],
			[
				'Parameter $j of method NamedArgumentsMethod\Foo::doFoo() expects int, string given.',
				57,
			],
			[
				'Parameter $i of method NamedArgumentsMethod\Foo::doBaz() is passed by reference, so it expects variables only.',
				70,
			],
			[
				'Parameter $i of method NamedArgumentsMethod\Foo::doBaz() is passed by reference, so it expects variables only.',
				71,
			],
			[
				'Named argument cannot be followed by an unpacked (...) argument.',
				73,
			],
			[
				'Parameter $j of method NamedArgumentsMethod\Foo::doFoo() expects int, string given.',
				75,
			],
			[
				'Named argument cannot be followed by a positional argument.',
				77,
			],
			[
				'Missing parameter $j (int) in call to method NamedArgumentsMethod\Foo::doFoo().',
				77,
			],
			[
				'Parameter #3 ...$args of method NamedArgumentsMethod\Foo::doIpsum() expects string, int given.',
				87,
			],
			[
				'Parameter $b of method NamedArgumentsMethod\Foo::doIpsum() expects int, string given.',
				90,
			],
			[
				'Parameter $b of method NamedArgumentsMethod\Foo::doIpsum() expects int, string given.',
				91,
			],
			[
				'Parameter ...$args of method NamedArgumentsMethod\Foo::doIpsum() expects string, int given.',
				91,
			],
			[
				'Missing parameter $b (int) in call to method NamedArgumentsMethod\Foo::doIpsum().',
				92,
			],
			[
				'Missing parameter $a (int) in call to method NamedArgumentsMethod\Foo::doIpsum().',
				93,
			],
			[
				'Unpacked argument (...) cannot be followed by a non-unpacked argument.',
				94,
			],
		]);
	}

	public function testBug4199(): void
	{
		if (!self::$useStaticReflectionProvider && PHP_VERSION_ID < 80000) {
			$this->markTestSkipped('Test requires PHP 8.0.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;

		$this->analyse([__DIR__ . '/data/bug-4199.php'], [
			[
				'Cannot call method answer() on Bug4199\Baz|null.',
				37,
			],
		]);
	}

	public function testBug4188(): void
	{
		if (!self::$useStaticReflectionProvider && PHP_VERSION_ID < 70400) {
			$this->markTestSkipped('Test requires PHP 7.4.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;

		$this->analyse([__DIR__ . '/data/bug-4188.php'], []);
	}

	public function testOnlyRelevantUnableToResolveTemplateType(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/only-relevant-unable-to-resolve-template-type.php'], [
			[
				'Parameter #1 $a of method OnlyRelevantUnableToResolve\Foo::doBaz() expects array, int given.',
				41,
			],
			[
				'Unable to resolve the template type T in call to method OnlyRelevantUnableToResolve\Foo::doBaz()',
				41,
				'See: https://phpstan.org/blog/solving-phpstan-error-unable-to-resolve-template-type',
			],
		]);
	}

	public function testBug4552(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-4552.php'], []);
	}

	public function testBug2837(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-2837.php'], []);
	}

	public function testBug2298(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-2298.php'], []);
	}

	public function testBug1661(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-1661.php'], []);
	}

	public function testBug1656(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-1656.php'], []);
	}

	public function testBug3534(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3534.php'], []);
	}

	public function testBug4557(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/../../Analyser/data/bug-4557.php'], []);
	}

	public function testBug4209(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/../../Analyser/data/bug-4209.php'], []);
	}

	public function testBug4209Two(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/../../Analyser/data/bug-4209-2.php'], []);
	}

	public function testBug3321(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/../../Analyser/data/bug-3321.php'], []);
	}

	public function testBug4498(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/../../Analyser/data/bug-4498.php'], []);
	}

	public function testBug3922(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/../../Analyser/data/bug-3922.php'], [
			[
				'Parameter #1 $query of method Bug3922\FooQueryHandler::handle() expects Bug3922\FooQuery, Bug3922\BarQuery given.',
				63,
			],
		]);
	}

	public function testBug4642(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/../../Analyser/data/bug-4642.php'], []);
	}

	public function testBug4008(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-4008.php'], []);
	}

	public function testBug3546(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3546.php'], []);
	}

	public function testBug4800(): void
	{
		if (!self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires static reflection.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->phpVersion = 80000;
		$this->analyse([__DIR__ . '/data/bug-4800.php'], [
			[
				'Missing parameter $bar (string) in call to method Bug4800\HelloWorld2::a().',
				36,
			],
		]);
	}

	public function testGenericReturnTypeResolvedToNever(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/generic-return-type-never.php'], [
			[
				'Return type of call to method GenericReturnTypeNever\Foo::doBar() contains unresolvable type.',
				70,
			],
			[
				'Return type of call to method GenericReturnTypeNever\Foo::doBazBaz() contains unresolvable type.',
				73,
			],
		]);
	}

	public function testUnableToResolveCallbackParameterType(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/unable-to-resolve-callback-parameter-type.php'], []);
	}

	public function testBug4083(): void
	{
		if (PHP_VERSION_ID < 70400 && !self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires PHP 7.4.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-4083.php'], []);
	}

	public function testBug5253(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-5253.php'], []);
	}

	public function testBug4844(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-4844.php'], []);
	}

	public function testBug5258(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-5258.php'], []);
	}

	public function testGenericObjectLowerBound(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/../../Analyser/data/generic-object-lower-bound.php'], [
			[
				'Parameter #1 $c of method GenericObjectLowerBound\Foo::doFoo() expects GenericObjectLowerBound\Collection<GenericObjectLowerBound\Cat|GenericObjectLowerBound\Dog>, GenericObjectLowerBound\Collection<GenericObjectLowerBound\Dog> given.',
				48,
			],
		]);
	}

	public function testNonEmptyStringVerbosity(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/non-empty-string-verbosity.php'], [
			[
				'Parameter #1 $i of method NonEmptyStringVerbosity\Foo::doBar() expects int, string given.',
				13,
			],
		]);
	}

	public function testBug5536(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-5536.php'], []);
	}

	public function testBug5372(): void
	{
		if (!self::$useStaticReflectionProvider && PHP_VERSION_ID < 70400) {
			$this->markTestSkipped('Test requires PHP 7.4.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-5372.php'], [
			[
				'Parameter #1 $list of method Bug5372\Foo::takesStrings() expects Bug5372\Collection<int, string>, Bug5372\Collection<int, class-string> given.',
				72,
			],
			/*[
				'Parameter #1 $list of method Bug5372\Foo::takesStrings() expects Bug5372\Collection<int, string>, Bug5372\Collection<int, literal-string> given.',
				85,
			],*/
		]);
	}

	public function testLiteralString(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/literal-string.php'], [
			[
				'Parameter #1 $s of method LiteralStringMethod\Foo::requireLiteralString() expects literal-string, string given.',
				18,
			],
			[
				'Parameter #1 $s of method LiteralStringMethod\Foo::requireLiteralString() expects literal-string, int given.',
				21,
			],
			[
				'Parameter #1 $s of method LiteralStringMethod\Foo::requireLiteralString() expects literal-string, 1 given.',
				22,
			],
			[
				'Parameter #1 $s of method LiteralStringMethod\Foo::requireLiteralString() expects literal-string, mixed given.',
				25,
			],
			[
				'Parameter #1 $a of method LiteralStringMethod\Foo::requireArrayOfLiteralStrings() expects array<literal-string>, array<string> given.',
				58,
			],
			[
				'Parameter #1 $a of method LiteralStringMethod\Foo::requireArrayOfLiteralStrings() expects array<literal-string>, array given.',
				60,
			],
			[
				'Parameter #1 $s of method LiteralStringMethod\Foo::requireLiteralString() expects literal-string, array<string, mixed> given.',
				65,
			],
			[
				'Parameter #1 $s of method LiteralStringMethod\Foo::requireLiteralString() expects literal-string, mixed given.',
				66,
			],
			[
				'Parameter #1 $s of method LiteralStringMethod\Foo::requireLiteralString() expects literal-string, mixed given.',
				67,
			],
		]);
	}

	public function testBug3555(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3555.php'], [
			[
				'Parameter #1 $arg of method Bug3555\Enum::run() expects 1|2|3|4|5|6|7|8|9, 100 given.',
				28,
			],
		]);
	}

	public function testBug3530(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3530.php'], []);
	}

	public function testBug5562(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-5562.php'], []);
	}

	public function testBug4211(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-4211.php'], []);
	}

	public function testBug3514(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3514.php'], []);
	}

	public function testBug3465(): void
	{
		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-3465.php'], []);
	}

	public function testBug5868(): void
	{
		if (PHP_VERSION_ID < 80000) {
			$this->markTestSkipped('Test requires PHP 8.0');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-5868.php'], [
			[
				'Cannot call method nullable1() on Bug5868\HelloWorld|null.',
				14,
			],
			[
				'Cannot call method nullable2() on Bug5868\HelloWorld|null.',
				15,
			],
			[
				'Cannot call method nullable3() on Bug5868\HelloWorld|null.',
				16,
			],
		]);
	}

	public function testBug5460(): void
	{
		if (!self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires static reflection.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;
		$this->analyse([__DIR__ . '/data/bug-5460.php'], []);
	}

	public function testFirstClassCallable(): void
	{
		if (PHP_VERSION_ID < 80100 && !self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires PHP 8.1.');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;

		// handled by a different rule
		$this->analyse([__DIR__ . '/data/first-class-method-callable.php'], []);
	}

	public function testEnums(): void
	{
		if (PHP_VERSION_ID < 80100) {
			$this->markTestSkipped('This test needs PHP 8.1');
		}

		$this->checkThisOnly = false;
		$this->checkNullables = true;
		$this->checkUnionTypes = true;

		$this->analyse([__DIR__ . '/data/call-method-in-enum.php'], [
			[
				'Call to an undefined method CallMethodInEnum\Foo::doNonexistent().',
				11,
			],
			[
				'Call to an undefined method CallMethodInEnum\Bar::doNonexistent().',
				22,
			],
		]);
	}

}

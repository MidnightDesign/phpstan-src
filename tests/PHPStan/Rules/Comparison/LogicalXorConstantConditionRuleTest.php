<?php declare(strict_types = 1);

namespace PHPStan\Rules\Comparison;

use PHPStan\Rules\Rule as TRule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LogicalXorConstantConditionRule>
 */
class LogicalXorConstantConditionRuleTest extends RuleTestCase
{

	protected function getRule(): TRule
	{
		return new LogicalXorConstantConditionRule(
			new ConstantConditionRuleHelper(
				new ImpossibleCheckTypeHelper(
					self::createReflectionProvider(),
					$this->getTypeSpecifier(),
					[],
					$this->shouldTreatPhpDocTypesAsCertain(),
				),
				$this->shouldTreatPhpDocTypesAsCertain(),
			),
			$this->shouldTreatPhpDocTypesAsCertain(),
			false,
			true,
		);
	}

	public function testRule(): void
	{
		$tipText = 'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.';
		$this->analyse([__DIR__ . '/data/logical-xor.php'], [
			[
				'Left side of xor is always true.',
				14,
			],
			[
				'Right side of xor is always false.',
				14,
			],
			[
				'Left side of xor is always false.',
				17,
			],
			[
				'Right side of xor is always true.',
				17,
			],
			[
				'Left side of xor is always true.',
				20,
				$tipText,
			],
			[
				'Right side of xor is always true.',
				20,
				$tipText,
			],
			[
				'Left side of xor is always true.',
				24,
			],
			[
				'Right side of xor is always false.',
				24,
			],
		]);
	}

}

<?php

namespace Strrev;

use function PHPStan\Testing\assertType;

class Foo
{
	/**
	 * @param string $string
	 * @param non-empty-string $nonEmptyString
	 * @param non-falsy-string $nonFalsyString
	 * @param numeric-string $numericString
	 * @param lowercase-string $lowercaseString
	 * @param uppercase-string $uppercaseString
	 * @param 'foo'|'bar' $constantStrings
	 *
	 * @return void
	 */
	public function test(
		string $string,
		string $nonEmptyString,
		string $nonFalsyString,
		string $numericString,
		string $lowercaseString,
		string $uppercaseString,
		string $constantStrings,
	) {
		assertType('string', strrev($string));
		assertType('non-empty-string', strrev($nonEmptyString));
		assertType('non-falsy-string', strrev($nonFalsyString));
		assertType('non-empty-string', strrev($numericString));
		assertType('lowercase-string', strrev($lowercaseString));
		assertType('uppercase-string', strrev($uppercaseString));
		assertType("'oof'|'rab'", strrev($constantStrings));
	}
}

<?php declare(strict_types=1);

namespace Bug1021;

use function PHPStan\Testing\assertType;

function foobar() {
	$x = [1, 2, 3];

	foreach ([4, 5, 6] as $i) {
		if (rand(0, 1)) {
			array_shift($x);
		}
	}

	assertType('array<1|2|3>&list', $x);

	if ($x) {
	}
}

function foo(array $x) {
	if ($x) {
		array_shift($x);

		assertType('array', $x);

		if ($x) {
			echo "";
		}
	}
}

<?php // lint >= 8.4

namespace Bug12473Types;

use ReflectionClass;
use function PHPStan\Testing\assertType;

class Picture
{
}

class PictureUser extends Picture
{
}

class PictureProduct extends Picture
{
}

/**
 * @param class-string $a
 */
function doFoo(string $a): void
{
	$r = new ReflectionClass($a);
	assertType('ReflectionClass<object>', $r);
	if ($r->isSubclassOf(Picture::class)) {
		assertType('ReflectionClass<Bug12473Types\\Picture>', $r);
	} else {
		assertType('ReflectionClass<object>', $r);
	}
	assertType('ReflectionClass<Bug12473Types\Picture>|ReflectionClass<object>', $r);
}

/**
 * @param class-string<Picture> $a
 */
function doFoo2(string $a): void
{
	$r = new ReflectionClass($a);
	assertType('ReflectionClass<Bug12473Types\\Picture>', $r);
	if ($r->isSubclassOf(Picture::class)) {
		assertType('ReflectionClass<Bug12473Types\\Picture>', $r);
	} else {
		assertType('*NEVER*', $r);
	}
	assertType('ReflectionClass<Bug12473Types\\Picture>', $r);
}

<?php

/**
 * Test: Nette\Utils\ArrayList basic usage.
 */

use Nette\Utils\ArrayList;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


class Person
{
	private $name;


	public function __construct($name)
	{
		$this->name = $name;
	}


	public function sayHi()
	{
		return "My name is $this->name";
	}
}


test(function () {
	$list = new ArrayList;
	$jack = new Person('Jack');
	$mary = new Person('Mary');

	$list[] = $mary;
	$list[] = $jack;

	Assert::same($mary, $list[0]);
	Assert::same($jack, $list[1]);


	Assert::same([
		$mary,
		$jack,
	], iterator_to_array($list));


	foreach ($list as $key => $person) {
		$tmp[] = $key . ' => ' . $person->sayHi();
	}
	Assert::same([
		'0 => My name is Mary',
		'1 => My name is Jack',
	], $tmp);


	Assert::same(2, $list->count());
	Assert::same(2, count($list));

	unset($list[1]);
	Assert::same([
		$mary,
	], iterator_to_array($list));

	$list->prepend('First');
	Assert::same('First', $list[0], 'Value "First" should be on the start of the array');
});


test(function () {
	$list = new ArrayList;
	$list[] = 'a';
	$list[] = 'b';

	Assert::exception(function () use ($list) {
		$list[-1] = true;
	}, OutOfRangeException::class, 'Offset invalid or out of range');

	Assert::exception(function () use ($list) {
		$list[2] = true;
	}, OutOfRangeException::class, 'Offset invalid or out of range');

	Assert::error(function () use ($list) {
		$list['key'] = true;
	}, E_USER_NOTICE, 'Index is not integer.');
});


test(function () {
	$list = new ArrayList;
	$list[] = 'a';
	$list[] = 'b';

	Assert::exception(function () use ($list) {
		$tmp = $list[-1];
	}, OutOfRangeException::class, 'Offset invalid or out of range');

	Assert::exception(function () use ($list) {
		$tmp = $list[2];
	}, OutOfRangeException::class, 'Offset invalid or out of range');

	Assert::error(function () use ($list) {
		$tmp = $list['key'];
	}, E_USER_NOTICE, 'Index is not integer.');
});


test(function () {
	$list = new ArrayList;
	$list[] = 'a';
	$list[] = 'b';

	Assert::exception(function () use ($list) {
		unset($list[-1]);
	}, OutOfRangeException::class, 'Offset invalid or out of range');

	Assert::exception(function () use ($list) {
		unset($list[2]);
	}, OutOfRangeException::class, 'Offset invalid or out of range');

	Assert::error(function () use ($list) {
		unset($list['key']);
	}, E_USER_NOTICE, 'Index is not integer.');
});

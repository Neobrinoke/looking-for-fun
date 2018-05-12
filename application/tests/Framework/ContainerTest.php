<?php

namespace Tests\Framework;

use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
	public function testGetMethod()
	{
		$test1 = app(Test1::class);

		$this->assertInstanceOf(Test1::class, $test1);
	}

	public function testGetMethodWithAutoInjectionConstructor()
	{
		/** @var Test2 $test2 */
		$test2 = app(Test2::class);

		$this->assertInstanceOf(Test2::class, $test2);
		$this->assertInstanceOf(Test1::class, $test2->test1);
	}

	public function testSetMethod()
	{
		app()->set('set_method', function () {
			return 'test';
		});

		$this->assertEquals('test', app('set_method'));
	}
}

class Test1
{
	private $iuniqId = null;

	public function __construct()
	{
		$this->iuniqId = uniqid();
	}
}

class Test2
{
	private $iuniqId = null;
	public $test1;

	public function __construct(Test1 $test1)
	{
		$this->iuniqId = uniqid();
		$this->test1 = $test1;
	}
}
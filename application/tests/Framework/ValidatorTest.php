<?php

namespace Framework;

use App\Framework\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
	public function testRequiredWithValidValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'required'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	public function testRequiredWithWrongValues()
	{
		$values = ['name' => ''];
		$rules = ['name' => 'required'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['name' => 'Le champ name est requis.'], $validator->validate());
	}

	public function testMaxWithValidValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'max:50'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	public function testMaxWithWrongValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'max:5'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['name' => 'Le champ name doit être inférieur à 5 caractères.'], $validator->validate());
	}

	public function testMinWithValidValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'min:5'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	public function testMinWithWrongValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'min:50'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['name' => 'Le champ name doit être supérieur à 50 caractères.'], $validator->validate());
	}

	public function testEmailWithValidValues()
	{
		$values = ['email' => 'neobrinoke@gmail.com'];
		$rules = ['email' => 'email'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	public function testEmailWithWrongValues()
	{
		$values = ['email' => 'neobrinoke'];
		$rules = ['email' => 'email'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['email' => 'L\'email doit être un email valide.'], $validator->validate());
	}

	public function testConfirmWithValidValues()
	{
		$values = ['password' => 'neobrinoke', 'password_conf' => 'neobrinoke'];
		$rules = ['password' => 'confirm'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	public function testConfirmWithWrongValues()
	{
		$values = ['password' => 'neobrinoke', 'password_conf' => ''];
		$rules = ['password' => 'confirm'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['password' => 'Le champ password doit être identique au champ de confirmation.'], $validator->validate());
	}

	public function testUniqueWithValidValues()
	{
		$values = ['email' => 'unique@email.com'];
		$rules = ['email' => 'unique:User'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	public function testUniqueWithWrongValues()
	{
		$values = ['email' => 'neobrinoke@gmail.com'];
		$rules = ['email' => 'unique:User'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['email' => 'Le champ email doit être unique.'], $validator->validate());
	}
}
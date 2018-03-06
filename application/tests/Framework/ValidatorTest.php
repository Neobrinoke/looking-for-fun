<?php

namespace Framework;

use App\Framework\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
	/**
	 * @throws \Exception
	 */
	public function testRequiredWithValidValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'required'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	/**
	 * @throws \Exception
	 */
	public function testRequiredWithWrongValues()
	{
		$values = ['name' => ''];
		$rules = ['name' => 'required'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['name' => 'Le champ name est requis.'], $validator->validate());
	}

	/**
	 * @throws \Exception
	 */
	public function testMaxWithValidValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'max:50'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	/**
	 * @throws \Exception
	 */
	public function testMaxWithWrongValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'max:5'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['name' => 'Le champ name doit être inférieur à 5 caractères.'], $validator->validate());
	}

	/**
	 * @throws \Exception
	 */
	public function testMinWithValidValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'min:5'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	/**
	 * @throws \Exception
	 */
	public function testMinWithWrongValues()
	{
		$values = ['name' => 'neobrinoke'];
		$rules = ['name' => 'min:50'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['name' => 'Le champ name doit être supérieur à 50 caractères.'], $validator->validate());
	}

	/**
	 * @throws \Exception
	 */
	public function testEmailWithValidValues()
	{
		$values = ['email' => 'neobrinoke@gmail.com'];
		$rules = ['email' => 'email'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	/**
	 * @throws \Exception
	 */
	public function testEmailWithWrongValues()
	{
		$values = ['email' => 'neobrinoke'];
		$rules = ['email' => 'email'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['email' => 'L\'email doit être un email valide.'], $validator->validate());
	}

	/**
	 * @throws \Exception
	 */
	public function testPasswordWithValidValues()
	{
		$values = ['password' => 'neobrinoke', 'password_conf' => 'neobrinoke'];
		$rules = ['password' => 'password'];

		$validator = new Validator($values, $rules);

		$this->assertEquals([], $validator->validate());
	}

	/**
	 * @throws \Exception
	 */
	public function testPasswordWithWrongValues()
	{
		$values = ['password' => 'neobrinoke', 'password_conf' => ''];
		$rules = ['password' => 'password'];

		$validator = new Validator($values, $rules);

		$this->assertEquals(['password' => 'Le mot de passe et le mot de passe de confirmation doivent être identique.'], $validator->validate());
	}
}
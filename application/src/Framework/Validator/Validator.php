<?php

namespace App\Framework\Validator;

class Validator
{
	public const VALIDATOR_TYPES = [
		self::VALIDATOR_MIN,
		self::VALIDATOR_MAX,
		self::VALIDATOR_EMAIL,
		self::VALIDATOR_REQUIRED,
		self::VALIDATOR_PASSWORD
	];

	public const VALIDATOR_MIN = 'min';
	public const VALIDATOR_MAX = 'max';
	public const VALIDATOR_EMAIL = 'email';
	public const VALIDATOR_REQUIRED = 'required';
	public const VALIDATOR_PASSWORD = 'password';

	/** @var array */
	private $values;

	/** @var array */
	private $validators;

	/**
	 * Validator constructor.
	 *
	 * @param array $values
	 * @param array $validators
	 */
	public function __construct(array $values, array $validators)
	{
		$this->values = $values;
		$this->validators = $this->parseValidators($validators);
	}

	/**
	 * Return array of errors (empty if not errors)
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function validate()
	{
		$errors = [];
		foreach ($this->validators as $var => $rules) {
			foreach ($rules as $key => $value) {
				if (!in_array($key, self::VALIDATOR_TYPES)) {
					throw new \Exception(sprintf("Invalid validator type [%s]", $key));
				}

				if ($key == self::VALIDATOR_MIN) {
					if (strlen($this->values[$var]) < $value) {
						$errors[$var] = 'Le champ ' . $var . ' doit être supérieur à ' . $value . ' caractères.';
					}
				}

				if ($key == self::VALIDATOR_MAX) {
					if (strlen($this->values[$var]) > $value) {
						$errors[$var] = 'Le champ ' . $var . ' doit être inférieur à ' . $value . ' caractères.';
					}
				}

				if ($key == self::VALIDATOR_REQUIRED) {
					if (!isValid($this->values[$var])) {
						$errors[$var] = 'Le champ ' . $var . ' est requis.';
					}
				}

				if ($key == self::VALIDATOR_EMAIL) {
					if(!filter_var($this->values[$var], FILTER_VALIDATE_EMAIL)) {
						$errors[$var] = 'L\'email doit être un email valide.';
					}
				}

				if ($key == self::VALIDATOR_PASSWORD) {
					if($this->values[$var] != @$this->values[$var . '_conf']) {
						$errors[$var] = 'Le mot de passe et le mot de passe de confirmation doivent être identique.';
					}
				}
			}
		}
		return $errors;
	}

	/**
	 * Parse validators string to array
	 *
	 * @param array $validators
	 * @return array
	 */
	private function parseValidators(array $validators): array
	{
		$validates = [];
		foreach ($validators as $key => $validator) {

			$rules = [];
			foreach (explode('|', $validator) as $rule) {
				$ruleDetails = explode(':', $rule);
				$rules[$ruleDetails[0]] = isset($ruleDetails[1]) ? $ruleDetails[1] : true;
			}

			$validates[$key] = $rules;
		}
		return $validates;
	}
}
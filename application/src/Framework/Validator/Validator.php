<?php

namespace App\Framework\Validator;

use App\Framework\ORM\Entity;

class Validator
{
	public const VALIDATOR_TYPES = [
		self::VALIDATOR_MIN,
		self::VALIDATOR_MAX,
		self::VALIDATOR_EMAIL,
		self::VALIDATOR_UNIQUE,
		self::VALIDATOR_CONFIRM,
		self::VALIDATOR_REQUIRED
	];

	public const VALIDATOR_MIN = 'min';
	public const VALIDATOR_MAX = 'max';
	public const VALIDATOR_EMAIL = 'email';
	public const VALIDATOR_UNIQUE = 'unique';
	public const VALIDATOR_CONFIRM = 'confirm';
	public const VALIDATOR_REQUIRED = 'required';

	/** @var array */
	private $values = [];

	/** @var array */
	private $validators = [];

	/** @var array */
	private $errors = [];

	/** @var array */
	private $newVars = [];

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
	 * Return array of new values
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function validate(): bool
	{
		foreach ($this->validators as $var => $rules) {
			foreach ($rules as $key => $value) {
				if (!in_array($key, self::VALIDATOR_TYPES)) {
					throw new \Exception(sprintf("Invalid validator type [%s]", $key));
				}

				if ($key == self::VALIDATOR_MIN) {
					if (strlen($this->values[$var]) < $value) {
						$this->errors[$var] = 'Le champ ' . $var . ' doit être supérieur à ' . $value . ' caractères.';
					}
				}

				if ($key == self::VALIDATOR_MAX) {
					if (strlen($this->values[$var]) > $value) {
						$this->errors[$var] = 'Le champ ' . $var . ' doit être inférieur à ' . $value . ' caractères.';
					}
				}

				if ($key == self::VALIDATOR_REQUIRED) {
					if (!isValid($this->values[$var])) {
						$this->errors[$var] = 'Le champ ' . $var . ' est requis.';
					}
				}

				if ($key == self::VALIDATOR_EMAIL) {
					if (!filter_var($this->values[$var], FILTER_VALIDATE_EMAIL)) {
						$this->errors[$var] = 'L\'email doit être un email valide.';
					}
				}

				if ($key == self::VALIDATOR_CONFIRM) {
					if ($this->values[$var] != @$this->values[$var . '_conf']) {
						$this->errors[$var] = 'Le champ ' . $var . ' doit être identique au champ de confirmation.';
					}
				}

				if ($key == self::VALIDATOR_UNIQUE) {
					$value = 'App\\Entity\\' . $value;

					/** True for bypass the safe delete option of entity, we do not need entity can have the same value as an deleted entity */
					/** @var Entity $value */
					$entity = $value::findOneBy([$var => $this->values[$var]], true);
					if (!is_null($entity)) {
						$this->errors[$var] = 'Le champ ' . $var . ' doit être unique.';
					}
				}
			}
		}

		return empty($this->errors);
	}

	/**
	 * Return errors
	 *
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors;
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
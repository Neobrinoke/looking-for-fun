<?php

namespace App\Framework\Validator;

use App\Framework\Database\Entity;
use App\Framework\Support\Collection;

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

	/** @var Collection */
	private $errors;

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
		$this->errors = new Collection();
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
						$this->errors->set($var, sprintf("Le champ %s doit être supérieur à %s caractères.", $var, $value));
					}
				}

				if ($key == self::VALIDATOR_MAX) {
					if (strlen($this->values[$var]) > $value) {
						$this->errors->set($var, sprintf("Le champ %s doit être inférieur à %s caractères.", $var, $value));
					}
				}

				if ($key == self::VALIDATOR_REQUIRED) {
					if (!isValid($this->values[$var])) {
						$this->errors->set($var, sprintf("Le champ %s est requis.", $var));
					}
				}

				if ($key == self::VALIDATOR_EMAIL) {
					if (!filter_var($this->values[$var], FILTER_VALIDATE_EMAIL)) {
						$this->errors->set($var, sprintf("L'email doit être un email valide."));
					}
				}

				if ($key == self::VALIDATOR_CONFIRM) {
					if (!isset($this->values[$var . '_conf']) || $this->values[$var] != $this->values[$var . '_conf']) {
						$this->errors->set($var, sprintf("Le champ %s doit être identique au champ de confirmation.", $var));
					}
				}

				if ($key == self::VALIDATOR_UNIQUE) {
					$value = 'App\\Entity\\' . $value;

					/** True for bypass the safe delete option of entity, we do not need entity can have the same value as an deleted entity */
					/** @var Entity $value */
					$entity = $value::findOneBy([$var => $this->values[$var]], true);
					if (!is_null($entity)) {
						$this->errors->set($var, sprintf("Le champ %s doit être unique.", $var));
					}
				}
			}
		}

		return $this->getErrors()->isEmpty();
	}

	/**
	 * Return errors
	 *
	 * @return Collection
	 */
	public function getErrors(): Collection
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
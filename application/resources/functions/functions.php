<?php

/**
 * Return protected variable
 *
 * @param string $string
 * @return string
 */
function protect(string $string): string
{
	return trim(hex2bin(str_replace('c2a0', '20', bin2hex($string))));
}

/**
 * Check if variables are valid (is set and not empty)
 * Retrieve all arg with the function func_get_args()
 *
 * @return bool
 */
function isValid(): bool
{
	foreach (func_get_args() as $arg) {
		if (!isset($arg) || empty($arg)) {
			return false;
		}
	}
	return true;
}

/**
 * Pars camel case to snake case string
 *
 * @param $input
 * @return string
 */
function camelToSnakeCase(string $input): string
{
	preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
	$ret = $matches[0];
	foreach ($ret as &$match) {
		$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
	}
	return implode('_', $ret);
}

/**
 * Return old value with array and key
 *
 * @param array $values
 * @param string $key
 * @return mixed|string
 */
function old(array $values, string $key)
{
	return isset($values[$key]) ? $values[$key] : '';
}
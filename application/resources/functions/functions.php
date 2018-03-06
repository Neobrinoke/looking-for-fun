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
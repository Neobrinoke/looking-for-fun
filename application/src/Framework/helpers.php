<?php

use App\Framework\Authentication\Auth;
use App\Framework\Container\Container;
use App\Framework\Renderer\Renderer;
use App\Framework\Router\Router;
use App\Framework\Session\Session;
use GuzzleHttp\Psr7\ServerRequest;

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
 * Return ago formated date
 *
 * @param string $date
 * @return string
 */
function agoDateFormat(string $date): string
{
	$time = time() - strtotime($date);

	if ($time < 1) {
		return 'à l\'instant';
	}

	$conditions = [
		365 * 24 * 60 * 60 => 'année',
		30 * 24 * 60 * 60 => 'mois',
		24 * 60 * 60 => 'jour',
		60 * 60 => 'heure',
		60 => 'minute',
		1 => 'seconde'
	];

	foreach ($conditions as $secs => $str) {
		$d = $time / $secs;
		if ($d >= 1) {
			$r = round($d);
			return 'il y\'a ' . $r . ' ' . $str . ($r > 1 && $str != 'mois' ? 's' : '');
		}
	}

	return "";
}

/**
 * Retrieve a environment variable by her key
 *
 * @param $key
 * @param null $default
 * @return array|bool|false|string
 */
function env($key, $default = null)
{
	$value = getenv($key);

	if ($value === false) {
		return $default;
	}

	switch (strtolower($value)) {
		case 'true':
		case '(true)':
			return true;
		case 'false':
		case '(false)':
			return false;
		case 'empty':
		case '(empty)':
			return '';
		case 'null':
		case '(null)':
			return null;
	}

	if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
		return substr($value, 1, -1);
	}

	return $value;
}

/**
 * Return instance of container or instance of $key
 *
 * @param null $key
 * @return Container|mixed
 * @throws Exception
 * @throws ReflectionException
 */
function app($key = null)
{
	if (is_null($key)) {
		return Container::getInstance();
	}
	return Container::getInstance()->get($key);
}

/**
 * Return auth instance
 *
 * @return Auth
 * @throws Exception
 * @throws ReflectionException
 */
function auth(): Auth
{
	return app(Auth::class);
}

/**
 * Render a named view
 *
 * @param string $name
 * @param array $params
 * @return string
 * @throws Exception
 * @throws ReflectionException
 */
function renderView(string $name, array $params = []): string
{
	return app(Renderer::class)->renderView($name, $params);
}

/**
 * Return router instance
 *
 * @return Router|mixed
 * @throws Exception
 * @throws ReflectionException
 */
function router(): Router
{
	return app(Router::class);
}

/**
 * Return href for named route
 *
 * @param string $name
 * @param array $params
 * @return string
 * @throws Exception
 */
function route(string $name, array $params = []): string
{
	return router()->generateUri($name, $params);
}

/**
 * Return session instance
 *
 * @return Session
 * @throws Exception
 * @throws ReflectionException
 */
function session(): Session
{
	return app(Session::class);
}

/**
 * Return current request
 *
 * @return ServerRequest
 * @throws Exception
 * @throws ReflectionException
 */
function request(): ServerRequest
{
	return app('request');
}

/**
 * Return old value with array and key
 *
 * @param string $key
 * @return mixed|null
 * @throws Exception
 * @throws ReflectionException
 */
function old(string $key)
{
	return session()->get('old_form')[$key] ?? null;
}
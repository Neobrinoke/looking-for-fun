<?php

namespace App\Framework\Router;

class Route
{
	public const DEFAULT_CONTROLLER_PATH = 'App\\Controller\\';

	/** @var string */
	private $method;

	/** @var string */
	private $path;

	/** @var string|callable */
	private $callback;

	/** @var string */
	private $name;

	/** @var string */
	private $regex;

	/** @var array */
	private $params = [];

	/**
	 * Route constructor.
	 *
	 * @param string $method
	 * @param string $path
	 * @param string $regex
	 * @param string $name
	 * @param string|callable $callback
	 */
	public function __construct(string $method, string $path, string $regex, string $name, $callback)
	{
		$this->method = $method;
		$this->regex = $regex;
		$this->path = $path;
		$this->name = $name;
		$this->callback = $callback;
	}

	/**
	 * Return true or false
	 *
	 * @param $url
	 * @return bool
	 */
	public function match($url): bool
	{
		if ($_SERVER['REQUEST_METHOD'] === $this->method) {
			if (preg_match($this->regex, trim($url, '/'), $params)) {
				array_shift($params);
				$this->params = $params;
				return true;
			}
		}
		return false;
	}

	/**
	 * Execute the callback
	 *
	 * @return mixed
	 */
	public function call()
	{
		$callable = $this->callback;

		if(is_string($this->callback)) {
			$actions = explode('@', $this->callback);
			$className = self::DEFAULT_CONTROLLER_PATH . $actions[0];
			$methodName = $actions[1];
			$callable = [new $className, $methodName];
		}

		return call_user_func_array($callable, $this->params);
	}

	public function getUri(array $params)
	{
		$path = $this->path;
		foreach ($params as $key => $value) {
			$path = str_replace('{' . $key . '}', $value, $path);
		}
		return $path;
	}
}
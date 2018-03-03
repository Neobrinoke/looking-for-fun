<?php

namespace App\Framework;

class Router
{
	/** @var array */
	private static $routes = [];

	/**
	 * Add get route
	 *
	 * @param string $path
	 * @param string $action
	 * @param string $name
	 */
	public static function get(string $path, string $action, string $name)
	{
		self::addRoute('GET', $path, $action, $name);
	}

	/**
	 * Add post route
	 *
	 * @param string $path
	 * @param string $action
	 * @param string $name
	 */
	public static function post(string $path, string $action, string $name)
	{
		self::addRoute('POST', $path, $action, $name);
	}

	/**
	 * Return the matched route
	 *
	 * @param string $url
	 * @return Route|null
	 */
	public static function match(string $url): ?Route
	{
		/** @var Route $route */
		foreach (self::$routes as $route) {
			if (preg_match($route->getPath(), $url, $params)) {
				if ($_SERVER['REQUEST_METHOD'] === $route->getMethod()) {
					$params = array_shift($params);
					if (is_array($params)) {
						$route->setParams($params);
					}
					return $route;
				}
			}
		}
		return null;
	}

	/**
	 * Add route with method
	 *
	 * @param string $method
	 * @param string $path
	 * @param string $action
	 * @param string $name
	 */
	private static function addRoute(string $method, string $path, string $action, string $name)
	{
		$path = '/^' . str_replace('/', '\/', $path) . '$/';

		$actions = explode('@', $action);

		$className = '\\App\\Controller\\' . $actions[0];
		$actionName = $actions[1];

		self::$routes[$name] = new Route($method, $path, [new $className, $actionName], $name);
	}
}
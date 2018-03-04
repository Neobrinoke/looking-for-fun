<?php

namespace App\Framework\Router;

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
	public static function run(string $url): string
	{
		/** @var Route $route */
		foreach (self::$routes as $route) {
			if ($route->match($url)) {
				return $route->call();
			}
		}
		return '<h1>Error 404</h1>';
	}

	/**
	 * Generate uri
	 *
	 * @param string $name
	 * @param array $params
	 * @return mixed
	 * @throws \Exception
	 */
	public static function generateUri(string $name, array $params = [])
	{
		$route = self::$routes[$name];
		if (!isset($route)) {
			throw new \Exception('No route match this name');
		}

		return $route->getUri($params);
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
		$regex = "#^" . preg_replace('#{([\w]+)}#', '([^/]+)', trim($path, '/')) . "$#i";
		self::$routes[$name] = new Route($method, $path, $regex, $action, $name);
	}
}
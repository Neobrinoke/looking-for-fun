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
	 * @param string $name
	 * @param string|callable $callback
	 */
	public static function get(string $path, string $name, $callback)
	{
		self::addRoute('GET', $path, $name, $callback);
	}

	/**
	 * Add post route
	 *
	 * @param string $path
	 * @param string $name
	 * @param string|callable $callback
	 */
	public static function post(string $path, string $name, $callback)
	{
		self::addRoute('POST', $path, $name, $callback);
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
	 * @param string $name
	 * @param $callback
	 */
	private static function addRoute(string $method, string $path, string $name, $callback)
	{
		$regex = "#^" . preg_replace('#{([\w]+)}#', '([^/]+)', trim($path, '/')) . "$#i";
		self::$routes[$name] = new Route($method, $path, $regex, $name, $callback);
	}
}
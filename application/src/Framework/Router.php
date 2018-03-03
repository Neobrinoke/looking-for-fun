<?php

namespace App\Framework;

class Router
{
	private static $routes = [];

	public static function execute($url)
	{
		$content = '<h1>Error 404</h1>';
		/** @var Route $route */
		foreach (self::$routes as $route) {
			if (preg_match($route->getPath(), $url, $params)) {
				if ($_SERVER['REQUEST_METHOD'] === $route->getMethod()) {
					array_shift($params);
					$content = call_user_func_array($route->getCallback(), array_values($params));
				}
			}
		}
		return $content;
	}

	public static function get(string $path, string $action, string $name)
	{
		self::addRoute('GET', $path, $action, $name);
	}

	public static function post(string $path, string $action, string $name)
	{
		self::addRoute('POST', $path, $action, $name);
	}

	private static function addRoute(string $method, string $path, string $action, string $name)
	{
		$path = '/^' . str_replace('/', '\/', $path) . '$/';

		$actions = explode('@', $action);

		$className = '\\App\\Controller\\' . $actions[0];
		$actionName = $actions[1];

		self::$routes[$name] = new Route($method, $path, [new $className, $actionName], $name);
	}
}
<?php

namespace App\Framework\Router;

use Psr\Http\Message\ServerRequestInterface;

class Router
{
	/** @var array */
	private $routes = [];

	/**
	 * Add get route
	 *
	 * @param string $path
	 * @param string|callable $callback
	 * @param string $name
	 * @param null|string $middleware
	 */
	public function get(string $path, $callback, string $name, ?string $middleware = null)
	{
		$this->addRoute('GET', $path, $callback, $name, $middleware);
	}

	/**
	 * Add post route
	 *
	 * @param string $path
	 * @param string|callable $callback
	 * @param string $name
	 * @param null|string $middleware
	 */
	public function post(string $path, $callback, string $name, ?string $middleware = null)
	{
		$this->addRoute('POST', $path, $callback, $name, $middleware);
	}

	/**
	 * Return the matched route
	 *
	 * @param ServerRequestInterface $request
	 * @return Route|null
	 */
	public function run(ServerRequestInterface $request): ?Route
	{
		/** @var Route $route */
		foreach ($this->routes as $route) {
			if ($route->match($request)) {
				return $route;
			}
		}
		return null;
	}

	/**
	 * Generate uri
	 *
	 * @param string $name
	 * @param array $params
	 * @return mixed
	 * @throws \Exception
	 */
	public function generateUri(string $name, array $params = [])
	{
		/** @var Route $route */
		$route = $this->routes[$name];
		if (!isset($route)) {
			throw new \Exception(sprintf("No route matched for this name [%s]", $name));
		}

		return $route->getUri($params);
	}

	/**
	 * Add route with method
	 *
	 * @param string $method
	 * @param string $path
	 * @param $callback
	 * @param string $name
	 * @param null|string $middleware
	 */
	private function addRoute(string $method, string $path, $callback, string $name, ?string $middleware = null)
	{
		$regex = "#^" . preg_replace('#{([\w]+)}#', '([^/]+)', trim($path, '/')) . "$#i";
		$this->routes[$name] = new Route($method, $path, $regex, $name, $callback, $middleware);
	}
}
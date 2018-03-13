<?php

namespace App\Framework\Router;

use App\Framework\Session\Session;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
	/** @var array */
	private $routes = [];

	/** @var Session */
	private $session;

	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	/**
	 * Add get route
	 *
	 * @param string $path
	 * @param string|callable $callback
	 * @param string $name
	 * @return Route
	 */
	public function get(string $path, $callback, string $name): Route
	{
		return $this->addRoute('GET', $path, $callback, $name);
	}

	/**
	 * Add post route
	 *
	 * @param string $path
	 * @param string|callable $callback
	 * @param string $name
	 * @return Route
	 */
	public function post(string $path, $callback, string $name): Route
	{
		return $this->addRoute('POST', $path, $callback, $name);
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
	 * @return string
	 * @throws \Exception
	 */
	public function generateUri(string $name, array $params = []): string
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
	 * @return Route
	 */
	private function addRoute(string $method, string $path, $callback, string $name): Route
	{
		$regex = "#^" . preg_replace('#{([\w]+)}#', '([^/]+)', trim($path, '/')) . "$#i";

		$route = new Route($method, $path, $regex, $callback, $name);
		$this->routes[$name] = $route;
		return $route;
	}
}
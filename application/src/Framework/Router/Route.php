<?php

namespace App\Framework\Router;

use App\Controller\Controller;
use App\Framework\Session\Session;
use GuzzleHttp\Psr7\Request;
use function PHPSTORM_META\type;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Route
{
	public const DEFAULT_CONTROLLER_PATH = 'App\\Controller\\';
	public const DEFAULT_MIDDLEWARE_PATH = 'App\\Middleware\\';

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

	/** @var array */
	private $middleware = [];

	/**
	 * Route constructor.
	 *
	 * @param string $method
	 * @param string $path
	 * @param string $regex
	 * @param string|callable $callback
	 * @param string $name
	 */
	public function __construct(string $method, string $path, string $regex, $callback, string $name)
	{
		$this->method = $method;
		$this->regex = $regex;
		$this->path = $path;
		$this->callback = $callback;
		$this->name = $name;
	}

	/**
	 * Return true if route matched or false
	 *
	 * @param ServerRequestInterface $request
	 * @return bool
	 */
	public function match(ServerRequestInterface $request): bool
	{
		if ($request->getMethod() === $this->method) {
			if (preg_match($this->regex, trim($request->getUri()->getPath(), '/'), $params)) {
				array_shift($params);

				if ($request->getMethod() === 'POST') {
					array_unshift($params, $request);
				}

				$this->params = $params;
				return true;
			}
		}

		return false;
	}

	/**
	 * Execute the callback
	 *
	 * @param ContainerInterface $container
	 * @param string $uri
	 * @return mixed
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
	public function call(ContainerInterface $container, string $uri)
	{
		/** Middleware system */
		foreach ($this->middleware as $middle) { // If we have a middleware defined
			$middleware = $container->get($middle);
			if (!is_bool($middleware->handle())) { // If return of middleware are not a boolean
				$container->get(Session::class)->set('last_uri', $uri);
				return $middleware->handle(); // return the response of middleware
			}
		}

		$callable = $this->callback;

		if (is_string($this->callback)) {
			$actions = explode('@', $this->callback);
			$className = self::DEFAULT_CONTROLLER_PATH . $actions[0];
			$methodName = $actions[1];
			$callable = [$container->get($className), $methodName];
		}

		return call_user_func_array($callable, $this->params);
	}

	/**
	 * Get uri from current route
	 *
	 * @param array $params
	 * @return string
	 */
	public function getUri(array $params): string
	{
		$path = $this->path;
		foreach ($params as $key => $value) {
			$path = str_replace('{' . $key . '}', $value, $path);
		}

		return $path;
	}

	/**
	 * Add one or multiple middleware
	 *
	 * @param string|array $middlewares
	 * @return $this
	 */
	public function middleware($middlewares): Route
	{
		if (is_string($middlewares)) {
			$middlewares = func_get_args();
		}

		foreach ($middlewares as $middleware) {
			$this->middleware[] = self::DEFAULT_MIDDLEWARE_PATH . $middleware;
		}

		return $this;
	}
	/**
	 * Retrieve the method for current route
	 *
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}

	/**
	 * Retrieve the path for current route
	 *
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path;
	}

	/**
	 * Retrieve the name for current route
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}


	/**
	 * Retrieve all params for current route
	 *
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}
}
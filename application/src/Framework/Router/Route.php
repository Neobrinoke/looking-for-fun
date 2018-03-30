<?php

namespace App\Framework\Router;

use App\Framework\Database\Entity;
use App\Framework\Session\Session;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;
use ReflectionException;

class Route
{
	public const DEFAULT_CONTROLLER_PATH = 'App\\Controller\\';
	public const DEFAULT_MIDDLEWARE_PATH = 'App\\Middleware\\';
	public const DEFAULT_ENTITY_PATH = 'App\\Entity\\';

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
		if ($request->getMethod() === $this->getMethod()) {
			if (preg_match($this->getRegex(), trim($request->getUri()->getPath(), '/'), $urlParams)) {
				array_shift($urlParams);

				preg_match($this->getRegex(), trim($this->getPath(), '/'), $pathParams);
				array_shift($pathParams);

				$params = [];
				for ($i = 0; $i < sizeof($urlParams); $i++) {
					$key = trim(trim($pathParams[$i], '{'), '}');
					$value = $urlParams[$i];

					$params[$key] = $value;
				}

				array_unshift($params, $request);

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
	 * @throws \Exception
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

		$callable = $this->getCallback();

		if (is_string($this->getCallback())) {
			$actions = explode('@', $this->getCallback());
			$className = self::DEFAULT_CONTROLLER_PATH . $actions[0];
			$methodName = $actions[1];
			$callable = [$container->get($className), $methodName];
		}

		$params = [];
		foreach ($this->getParams() as $key => $value) {
			$className = self::DEFAULT_ENTITY_PATH . ucfirst($key);

			try {
				$reflectionClass = new ReflectionClass($className);
			} catch (ReflectionException $e) {
				$reflectionClass = null;
			}

			if (!is_null($reflectionClass)) {
				/** @var Entity $className */
				$value = $className::find($value);
			}

			$params[$key] = $value;
		}

		return call_user_func_array($callable, $params);
	}

	/**
	 * Get uri from current route
	 *
	 * @param array $params
	 * @return string
	 */
	public function getUri(array $params): string
	{
		$path = $this->getPath();
		foreach ($params as $key => $value) {
			if ($value instanceof Entity) {
				$value = $value->getId();
			}
			$path = str_replace('{' . $key . '}', $value, $path);
		}

		return $path;
	}

	/**
	 * Add one or multiple middleware
	 *
	 * @param string|array $middlewares
	 * @return Route
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
	 * Retrieve the callback for current route
	 *
	 * @return callable|string
	 */
	public function getCallback()
	{
		return $this->callback;
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

	/**
	 * Retrieve regex for current route
	 *
	 * @return string
	 */
	public function getRegex(): string
	{
		return $this->regex;
	}
}
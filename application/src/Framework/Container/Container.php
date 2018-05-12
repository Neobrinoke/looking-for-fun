<?php

namespace App\Framework\Container;

use App\Framework\Http\Request;
use Exception;
use ReflectionClass;
use ReflectionException;

class Container
{
	/** @var Container */
	private static $instance = null;

	/** @var array */
	private $instances = [];

	/** @var array */
	private $resolvers = [];

	public function __construct()
	{
		$this->set('request', function () {
			return Request::fromGlobals();
		});
	}

	/**
	 * Get instance of this container
	 *
	 * @return Container
	 */
	public static function getInstance(): Container
	{
		if (is_null(static::$instance)) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Insert resolver
	 *
	 * @param $key
	 * @param $resolver
	 */
	public function set(string $key, callable $resolver)
	{
		$this->resolvers[$key] = $resolver;
	}

	/**
	 * Retrieve instance
	 *
	 * @param $key
	 * @return mixed
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public function get(string $key)
	{
		if (!isset($this->instances[$key])) {
			if (isset($this->resolvers[$key])) {
				$this->instances[$key] = $this->resolvers[$key]();
			} else {
				$reflectedClass = new ReflectionClass($key);
				if ($reflectedClass->isInstantiable()) {
					$constructor = $reflectedClass->getConstructor();
					if ($constructor) {
						$parameters = [];
						foreach ($reflectedClass->getConstructor()->getParameters() as $parameter) {
							if ($parameter->getClass()) {
								$parameters[] = $this->get($parameter->getClass()->getName());
							} else {
								$parameters[] = $parameter->getDefaultValue();
							}
						}
						$this->instances[$key] = $reflectedClass->newInstanceArgs($parameters);
					} else {
						$this->instances[$key] = $reflectedClass->newInstance();
					}
				} else {
					throw new Exception(sprintf("%s is not an instantiable Class", $key));
				}
			}
		}

		return $this->instances[$key];
	}
}
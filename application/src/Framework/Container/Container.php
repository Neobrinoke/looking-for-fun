<?php

namespace App\Framework\Container;

use App\Framework\Database\Adapter\PdoAdapter;
use App\Framework\Http\Request;
use App\Framework\Support\Collection;
use ReflectionClass;

class Container
{
	/** @var Container */
	private static $instance = null;

	/** @var Collection */
	private $instances;

	/** @var Collection */
	private $resolvers;

	public function __construct()
	{
		$this->instances = new Collection();
		$this->resolvers = new Collection();

		if (!$this->resolvers->has('request')) {
			$this->set('request', function () {
				return Request::fromGlobals();
			});
		}

		if (!$this->resolvers->has('pdo_instance')) {
			$this->set('pdo_instance', function () {
				return (new PdoAdapter())->getConnection();
			});
		}
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
		$this->resolvers->set($key, $resolver);
	}

	/**
	 * Retrieve instance
	 *
	 * @param $key
	 * @return mixed
	 * @throws \Exception
	 */
	public function get(string $key)
	{
		if (!$this->instances->has($key)) {
			if ($this->resolvers->has($key)) {
				$this->instances->set($key, $this->resolvers->get($key)());
			} else {
				$reflectedClass = new ReflectionClass($key);
				if ($reflectedClass->isInstantiable()) {
					$constructor = $reflectedClass->getConstructor();
					if ($constructor) {
						$parameters = new Collection();
						foreach ($reflectedClass->getConstructor()->getParameters() as $parameter) {
							if ($parameter->getClass()) {
								$parameters->add($this->get($parameter->getClass()->getName()));
							} else {
								$parameters->add($this->get($parameter->getDefaultValue()));
							}
						}
						$this->instances->set($key, $reflectedClass->newInstanceArgs($parameters->all()));
					} else {
						$this->instances->set($key, $reflectedClass->newInstance());
					}
				} else {
					throw new \Exception(sprintf("%s is not an instantiable Class", $key));
				}
			}
		}

		return $this->instances->get($key);
	}
}
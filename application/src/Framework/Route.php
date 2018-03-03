<?php

namespace App\Framework;

class Route
{
	/** @var string */
	private $method;

	/** @var string */
	private $path;

	/** @var callable */
	private $callback;

	/** @var string */
	private $name;

	/** @var array */
	private $params = [];

	/**
	 * Route constructor.
	 *
	 * @param string $method
	 * @param string $path
	 * @param callable $callback
	 * @param string $name
	 */
	public function __construct(string $method, string $path, callable $callback, string $name)
	{
		$this->method = $method;
		$this->path = $path;
		$this->callback = $callback;
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}

	/**
	 * @param string $method
	 */
	public function setMethod(string $method): void
	{
		$this->method = $method;
	}

	/**
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path;
	}

	/**
	 * @param string $path
	 */
	public function setPath(string $path): void
	{
		$this->path = $path;
	}

	/**
	 * @return callable
	 */
	public function getCallback(): callable
	{
		return $this->callback;
	}

	/**
	 * @param callable $callback
	 */
	public function setCallback(callable $callback): void
	{
		$this->callback = $callback;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}

	/**
	 * @param array $params
	 */
	public function setParams(array $params): void
	{
		$this->params = $params;
	}
}
<?php

namespace App\Framework\Session;

class Session
{
	/** @var array */
	private $session = [];

	public function __construct()
	{
		$this->init();
		$this->session = $_SESSION;
	}

	/**
	 * Retrieve session value with key
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get(string $key)
	{
		return $this->has($key) ? $this->session[$key] : null;
	}

	/**
	 * Retrieve session value with key and delete itself
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function getFlash(string $key)
	{
		$value = $this->get($key);
		$this->remove($key);
		return $value;
	}

	/**
	 * Insert session value on key with value
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set(string $key, $value): void
	{
		$this->session[$key] = $value;
		$this->update();
	}

	/**
	 * Unset session value with key
	 *
	 * @param string $key
	 */
	public function remove(string $key): void
	{
		unset($this->session[$key]);
		$this->update();
	}

	/**
	 * Check if session have this key
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has(string $key): bool
	{
		return isset($this->session[$key]);
	}

	/**
	 * Update session
	 */
	private function update()
	{
		$_SESSION = $this->session;
	}

	/**
	 * Initialize session
	 */
	private function init(): void
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
	}
}
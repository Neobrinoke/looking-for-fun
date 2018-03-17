<?php

namespace App\Framework\Session;

class Session
{
	/**
	 * Retrieve session value with key
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get(string $key)
	{
		$this->initSession();
		return $this->has($key) ? $_SESSION[$key] : null;
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
		$this->initSession();
		$_SESSION[$key] = $value;
	}

	/**
	 * Unset session value with key
	 *
	 * @param string $key
	 */
	public function remove(string $key): void
	{
		$this->initSession();
		unset($_SESSION[$key]);
	}

	/**
	 * Check if session have this key
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has(string $key): bool
	{
		$this->initSession();
		return isset($_SESSION[$key]);
	}

	/**
	 * Initialize session
	 */
	private function initSession(): void
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
	}
}
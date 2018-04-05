<?php

namespace App\Framework\Database;

use PDO;

class PdoAdapter
{
	/** @var PDO */
	private $pdo = null;

	public const ADAPTER_MYSQL = 'mysql';

	/**
	 * Adapter constructor.
	 *
	 * Initialise a pdo instance by driver
	 * @param bool $isTest
	 */
	public function __construct($isTest = false)
	{
		if (is_null($this->pdo)) {
			switch (env('DB_CONNECTION')) {
				default:
					$dsn = 'mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE') . ';port=' . env('DB_PORT') . '';
			}

			$options = [];
			$user = env('DB_USERNAME');
			$pass = env('DB_PASSWORD');

			if ($isTest) {
				$dsn = 'sqlite::memory:';
				$user = null;
				$pass = null;
				$options[] = [
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
				];
			}

			$this->pdo = new PDO($dsn, $user, $pass, $options);
		}

		return $this->pdo;
	}

	/**
	 * Return current PDO instance
	 *
	 * @return PDO
	 */
	public function getConnection(): PDO
	{
		return $this->pdo;
	}
}
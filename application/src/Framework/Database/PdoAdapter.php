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

			$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

			if ($isTest) {
				$this->pdo = new PDO('sqlite::memory:', null, null, $options);
			} else {
				$this->pdo = new PDO($dsn, env('DB_USERNAME'), env('DB_PASSWORD'), $options);
			}
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
<?php

namespace App\Framework\QueryBuilder;

use PDO;

class QueryBuilder
{
	public const QUERY_TYPE_SELECT = 'SELECT';
	public const QUERY_TYPE_INSERT = 'INSERT';
	public const QUERY_TYPE_UPDATE = 'UPDATE';
	public const QUERY_FETCH_TYPE = PDO::FETCH_NUM;

	/** @var string */
	private $table = '';

	/** @var array */
	private $fields = [];

	/** @var array */
	private $conditions = [];

	/** @var array */
	private $values = [];

	/** @var string */
	private $type = self::QUERY_TYPE_SELECT;

	/** @var PDO */
	private $pdoInstance;

	/**
	 * QueryBuilder constructor.
	 * @param string $type
	 */
	public function __construct(string $type = self::QUERY_TYPE_SELECT)
	{
		$this->type = $type;
	}

	/**
	 * Function for get PDO
	 */
	private function getPDO()
	{
		if (is_null($this->pdoInstance)) {
			$this->pdoInstance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE . ';port=' . DB_PORT . '', DB_USERNAME, DB_PASSWORD);
		}
		return $this->pdoInstance;
	}

	/**
	 * Add select elements
	 *
	 * @param string $table
	 * @param null|string $alias
	 * @return QueryBuilder
	 */
	public function table(string $table, ?string $alias = null): QueryBuilder
	{
		if (is_null($alias)) {
			$this->table = $table;
		} else {
			$this->table = $table . ' AS ' . $alias;
		}
		return $this;
	}

	/**
	 * Add fields
	 *
	 * @param array $fields
	 * @return QueryBuilder
	 */
	public function fields(array $fields): QueryBuilder
	{
		foreach ($fields as $field) {
			$this->field($field);
		}
		return $this;
	}

	/**
	 * Add field
	 *
	 * @param string $field
	 * @return QueryBuilder
	 */
	public function field(string $field): QueryBuilder
	{
		$this->fields[] = $field;
		return $this;
	}

	/**
	 * Add where elements
	 *
	 * @param string $condition
	 * @return QueryBuilder
	 */
	public function where(string $condition): QueryBuilder
	{
		$this->conditions[] = $condition;
		return $this;
	}

	/**
	 * Add values
	 *
	 * @param array $values
	 * @return QueryBuilder
	 */
	public function values(array $values): QueryBuilder
	{
		foreach ($values as $key => $value) {
			$this->value($value, $key);
		}
		return $this;
	}

	/**
	 * Add value
	 *
	 * @param $value
	 * @param null|string $key
	 * @return QueryBuilder
	 */
	public function value($value, ?string $key = null): QueryBuilder
	{
		if (is_null($key)) {
			$this->values[] = $value;
		} else {
			$this->values[$key] = $value;
		}
		return $this;
	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	public function getQuery(): string
	{
		if ($this->type === self::QUERY_TYPE_SELECT) {
			$sql = 'SELECT ' . implode(',', $this->fields) . ' FROM ' . $this->table;
			if (!empty($this->conditions)) {
				$sql .= ' WHERE ' . implode(' AND ', $this->conditions);
			}
		} else if ($this->type === self::QUERY_TYPE_INSERT) {
			$sql = 'INSERT INTO ' . $this->table . ' (' . implode(', ', $this->fields) . ') VALUES (:' . implode(', :', $this->fields) . ')';
		} else if ($this->type === self::QUERY_TYPE_UPDATE) {
			$sql = 'UPDATE ' . $this->table . ' SET ';
			foreach ($this->fields as $field) {
				if (end($this->fields) == $field) { // last
					$sql .= $field . ' = :' . $field;
				} else {
					$sql .= $field . ' = :' . $field . ', ';
				}
			}
			$sql .= ' WHERE ' . implode(' AND ', $this->conditions);
		} else {
			throw new \Exception('Invalid query builder type');
		}
		return $sql;
	}

	/**
	 * Return pdo fetch
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function getResult()
	{
		$statement = $this->getPDO()->prepare($this->getQuery());
		$statement->execute($this->values);
		return $statement->fetch(self::QUERY_FETCH_TYPE);
	}

	/**
	 * Return pdo fetch
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function getResults()
	{
		$statement = $this->getPDO()->prepare($this->getQuery());
		$statement->execute($this->values);
		return $statement->fetchAll(self::QUERY_FETCH_TYPE);
	}

	/**
	 * Execute current statement
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function execute(): bool
	{
		$statement = $this->getPDO()->prepare($this->getQuery());
		return $statement->execute($this->values);
	}

	/**
	 * @return int
	 */
	public function getLastInsertId(): int
	{
		return $this->getPDO()->lastInsertId();
	}
}
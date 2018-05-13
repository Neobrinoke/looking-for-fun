<?php

namespace App\Framework\Database\QueryBuilder;

use PDO;

class QueryBuilder
{
	public const QUERY_TYPE_SELECT = 'SELECT';
	public const QUERY_TYPE_INSERT = 'INSERT';
	public const QUERY_TYPE_UPDATE = 'UPDATE';
	public const QUERY_TYPE_DELETE = 'DELETE';
	public const QUERY_FETCH_TYPE = PDO::FETCH_ASSOC;

	/** @var string */
	protected $table = '';

	/** @var array */
	protected $fields = [];

	/** @var array */
	protected $conditions = [];

	/** @var array */
	protected $values = [];

	/** @var string */
	protected $type = self::QUERY_TYPE_SELECT;

	/** @var array */
	protected $ordersBy = [];

	/** @var string */
	protected $className = '';

	/**
	 * QueryBuilder constructor.
	 *
	 * @param $modelClassName
	 */
	public function __construct($modelClassName = null)
	{
		if (!is_null($modelClassName)) {
			$this->className = $modelClassName;
			$this->table = $modelClassName::TABLE;
		}
	}

	/**
	 * Create queryBuilder with insert type
	 *
	 * @return QueryBuilder
	 */
	public function insert(): QueryBuilder
	{
		$this->type = self::QUERY_TYPE_INSERT;
		return $this;
	}

	/**
	 * Create queryBuilder with update type
	 *
	 * @return QueryBuilder
	 */
	public function update(): QueryBuilder
	{
		$this->type = self::QUERY_TYPE_UPDATE;
		return $this;
	}

	/**
	 * Create queryBuilder with delete type
	 *
	 * @return QueryBuilder
	 */
	public function delete(): QueryBuilder
	{
		$this->type = self::QUERY_TYPE_DELETE;
		return $this;
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
	 * @param mixed $value
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
	 * Add order rules
	 *
	 * @param string $field
	 * @param string $order
	 * @return QueryBuilder
	 */
	public function orderBy(string $field, string $order = 'ASC'): QueryBuilder
	{
		$this->ordersBy[] = $field . ' ' . $order;
		return $this;
	}

	/**
	 * Add orders rules
	 *
	 * @param array $ordersBy
	 * @return QueryBuilder
	 */
	public function ordersBy(array $ordersBy): QueryBuilder
	{
		foreach ($ordersBy as $orderBy) {
			$orderBy = explode(' ', $orderBy);
			$this->orderBy($orderBy[0], $orderBy[1]);
		}
		return $this;
	}

	/**
	 * Retrieve formatted query
	 *
	 * @return string
	 */
	public function getQuery(): string
	{
		if ($this->type === self::QUERY_TYPE_SELECT) {
			$sql = 'SELECT ' . implode(',', $this->fields) . ' FROM ' . $this->table;
			if (!empty($this->conditions)) {
				$sql .= ' WHERE ' . implode(' AND ', $this->conditions);
			}
			if (!empty($this->ordersBy)) {
				$sql .= ' ORDER BY ' . implode(', ', $this->ordersBy);
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
			if (!empty($this->conditions)) {
				$sql .= ' WHERE ' . implode(' AND ', $this->conditions);
			}
		} else if ($this->type === self::QUERY_TYPE_DELETE) {
			$sql = 'DELETE FROM ' . $this->table;

			if (!empty($this->conditions)) {
				$sql .= ' WHERE ' . implode(' AND ', $this->conditions);
			}
		}
		return $sql;
	}

	/**
	 * Retrieve result for current query
	 *
	 * @return mixed|null
	 * @throws \Exception
	 */
	public function getResult()
	{
		$statement = $this->getPDO()->prepare($this->getQuery());
		$statement->execute($this->values);
		$statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
		$results = $statement->fetch();

		return $results ?: null;
	}

	/**
	 * Retrieve results for current query
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getResults(): array
	{
		$statement = $this->getPDO()->prepare($this->getQuery());
		$statement->execute($this->values);
		$statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
		return $statement->fetchAll();
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
	 * Retrieve the last inserted id
	 *
	 * @return int
	 * @throws \Exception
	 */
	public function getLastInsertId(): int
	{
		return $this->getPDO()->lastInsertId();
	}

	/**
	 * Retrieve or initialize a new instance of PDO
	 *
	 * @return PDO
	 * @throws \Exception
	 */
	private function getPDO(): PDO
	{
		return app('pdo_instance');
	}
}
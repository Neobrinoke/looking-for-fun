<?php

namespace App\Entity;

use PDO;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

abstract class Entity
{
	public const METHOD_TYPE_GET = 'get';
	public const METHOD_TYPE_SET = 'set';

	abstract public function getId();
	abstract public function setId(int $id);

	private static $pdoInstance = null;

	/**
	 * Function for get PDO
	 */
	private static function getPDO()
	{
		if(is_null(self::$pdoInstance)) {
			self::$pdoInstance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE . ';port=' . DB_PORT . '', DB_USERNAME, DB_PASSWORD);
		}
		return self::$pdoInstance;
	}

	/**
	 * Find one by id
	 *
	 * @param int $id
	 * @return Entity|null
	 * @throws \Exception
	 * @throws ReflectionException
	 */
	public static function find(int $id): ?Entity
	{
		$statement = static::getPDO()->prepare('SELECT * FROM ' . static::getTableName() . ' WHERE id = ?');
		$statement->execute([$id]);

		$result = $statement->fetch(PDO::FETCH_NUM);

		return (new static())->injectEntityProperties($result);
	}

	/**
	 * Find all
	 *
	 * @return array
	 * @throws \Exception
	 * @throws ReflectionException
	 */
	public static function all(): array
	{
		$entities = [];

		$statement = static::getPDO()->prepare('SELECT * FROM ' . static::getTableName());
		$statement->execute();

		$results = $statement->fetchAll(PDO::FETCH_NUM);

		foreach ($results as $result) {
			$entities[] = (new static())->injectEntityProperties($result);
		}

		return $entities;
	}

	/**
	 * Find one by something
	 *
	 * @param array $options
	 * @return Entity|null
	 * @throws \Exception
	 * @throws ReflectionException
	 */
	public static function findOneBy(array $options = []): ?Entity
	{
		if (empty($options)) {
			return null;
		}

		$sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE ';
		foreach ($options as $key => $value) {
			$sql .= $key . ' = :' . $key . ' ';
		}
		$sql = trim($sql);

		$statement = static::getPDO()->prepare($sql);
		$statement->execute($options);

		$result = $statement->fetch(PDO::FETCH_NUM);

		return (new static())->injectEntityProperties($result);
	}

	/**
	 * Find all by something
	 *
	 * @param array $options
	 * @return array
	 * @throws \Exception
	 * @throws ReflectionException
	 */
	public static function findBy(array $options = []): array
	{
		$entities = [];

		if (empty($options)) {
			return $entities;
		}

		$sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE ';
		foreach ($options as $key => $value) {
			$sql .= $key . ' = :' . $key . ' ';
		}
		$sql = trim($sql);

		$statement = static::getPDO()->prepare($sql);
		$statement->execute($options);

		$results = $statement->fetchAll(PDO::FETCH_NUM);

		foreach ($results as $result) {
			$entities[] = (new static())->injectEntityProperties($result);
		}

		return $entities;
	}

	/**
	 * Save(insert or update) current entity
	 *
	 * @return bool
	 * @throws \Exception
	 * @throws ReflectionException
	 */
	public function save(): bool
	{
		if (static::find($this->getId())) { // update
			return $this->update();
		} else { // create
			var_dump('Create');
			return $this->create();
		}
	}

	/**
	 * Create current entity
	 *
	 * @return bool
	 * @throws ReflectionException
	 * @throws \Exception
	 */
	private function create(): bool
	{
		$fields = static::getAllDatabaseFields();

		$sql = 'INSERT INTO ' . static::getTableName() . ' ';

		$beforeValues = '';
		$afterValues = '';
		foreach ($fields as $field) {
			if ($fields[0] == $field) { // first
				$beforeValues .= '(' . $field . ', ';
				$afterValues .= '(:' . $field . ', ';
			} else if (end($fields) == $field) { // last
				$beforeValues .= $field . ')';
				$afterValues .= ':' . $field . ')';
			} else {
				$beforeValues .= $field . ', ';
				$afterValues .= ':' . $field . ', ';
			}
		}
		$sql .= $beforeValues . ' VALUES ' . $afterValues;

		$statement = static::getPDO()->prepare($sql);
		$result = $statement->execute($this->retreiveEntityProperties($this));

		$lastId = static::getPDO()->lastInsertId();

		$this->setId($lastId);

		return $result;
	}

	/**
	 * Update current entity
	 *
	 * @return bool
	 */
	private function update(): bool
	{
		var_dump('Update');
		return false;
	}

	private function retreiveEntityProperties(Entity $entity): array
	{
		$results = [];

		$fields = static::getAllDatabaseFields();
		$methods = static::getAllMethods(static::METHOD_TYPE_GET);

//		var_dump($fields);
//		var_dump($methods);

		$i = 0;

		/** @var ReflectionMethod $method */
		foreach ($methods as $method) {
			$methodName = $method->getName();

			try {
				$reflectionClass = new ReflectionClass($method->getReturnType()->getName());
			} catch (ReflectionException $e) {
				$reflectionClass = null;
			}

			if (!is_null($reflectionClass)) { // Is object
				$className = $reflectionClass->getName();

				if ($className == 'DateTime') {
					/** @var \DateTime $var */
					$var = $entity->$methodName();
					$results[$fields[$i]] = is_null($var) ? null : $var->format('Y-m-d H:i:s');
				} else {
					throw new \Exception(sprintf("Object type (%s) does not managed by this ORM actually", $className));
				}
			} else {
				$results[$fields[$i]] = $entity->$methodName();
			}

			$i++;
		}

		return $results;
	}

	/**
	 * Set current entity properties with array pdo result
	 *
	 * @param mixed $result
	 * @return Entity|null
	 * @throws \Exception
	 * @throws ReflectionException
	 */
	private function injectEntityProperties($result): ?Entity
	{
		if (!is_array($result)) {
			return null;
		}

		$methods = static::getAllMethods(static::METHOD_TYPE_SET);

		$i = 0;

		/** @var ReflectionMethod $method */
		foreach ($methods as $method) {
			$methodName = $method->getName();

			try {
				$reflectionClass = new ReflectionClass($method->getParameters()[0]->getType()->getName());
			} catch (ReflectionException $e) {
				$reflectionClass = null;
			}

			if (!is_null($reflectionClass)) { // need instantiable parameter
				$className = $reflectionClass->getName();
				if ($className == 'DateTime') {
					$this->$methodName(is_null($result[$i]) ? null : new $className($result[$i]));
				} else {
					throw new \Exception(sprintf("Instantiable type (%s) does not managed by this ORM actually", $className));
				}
			} else {
				$this->$methodName($result[$i]);
			}
			$i++;
		}

		return $this;
	}

	/**
	 * Parse php doc for get table name
	 *
	 * @return string|null
	 * @throws \Exception
	 * @throws ReflectionException
	 */
	private static function getTableName()
	{
		$reflectClass = new ReflectionClass(static::class);

		preg_match('~@Table\(name="(.*?)"\)~', $reflectClass->getDocComment(), $match);

		if (!empty($match) && !empty($match[1])) {
			return $match[1];
		}

		throw new \Exception(sprintf("Invalid database table name in entity (%s)", static::class));
	}

	/**
	 * Parse php doc for get all database column name
	 *
	 * @return array
	 * @throws \Exception
	 * @throws ReflectionException
	 */
	private static function getAllDatabaseFields()
	{
		$reflectClass = new ReflectionClass(static::class);

		$fields = [];

		/** @var ReflectionProperty $property */
		foreach ($reflectClass->getProperties() as $property) {
			preg_match('~@Column\(name="(.*?)"\)~', $property->getDocComment(), $match);
			if (!empty($match) && !empty($match[1]) && $match[1] != 'id') {
				$fields[] = $match[1];
			}
		}

		if (empty($fields)) {
			throw new \Exception(sprintf("Invalid database columns name in entity (%s)", static::class));
		}

		return $fields;
	}


	/**
	 * Return all method by type ['get', 'set']
	 *
	 * @param string $type
	 * @return array
	 * @throws ReflectionException
	 * @throws \Exception
	 */
	private static function getAllMethods(string $type)
	{
		$reflectClass = new ReflectionClass(static::class);

		$methods = [];

		/** @var ReflectionProperty $property */
		foreach ($reflectClass->getProperties() as $property) {
			$methodName = $type . ucfirst($property->getName());
			$method = new ReflectionMethod(static::class, $methodName);
			if ($method) {
				if ($type !== 'get' || $method->getName() != 'getId') {
					$methods[] = $method;
				}
			}
		}

		if (empty($methods)) {
			throw new \Exception(sprintf("Methods for entity (%s) are empty", static::class));
		}

		return $methods;
	}
}
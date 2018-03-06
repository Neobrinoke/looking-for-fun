<?php

namespace App\Framework\ORM;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

abstract class Entity
{
	public const METHOD_TYPE_GET = 'get';
	public const METHOD_TYPE_SET = 'set';

	/**
	 * @return int
	 */
	abstract public function getId(): int;

	/**
	 * @param int $id
	 * @return mixed
	 */
	abstract public function setId(int $id);

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
		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table(static::getTableName());
		$queryBuilder->where('id = :id');
		$queryBuilder->value($id, 'id');

		return (new static())->injectEntityProperties($queryBuilder->getResult());
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
		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table(static::getTableName());

		$entities = [];
		foreach ($queryBuilder->getResults() as $result) {
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

		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table(static::getTableName());
		foreach ($options as $key => $value) {
			$queryBuilder->where($key . ' = :' . $key);
		}
		$queryBuilder->values($options);

		return (new static())->injectEntityProperties($queryBuilder->getResult());
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
		if (empty($options)) {
			return [];
		}

		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table(static::getTableName());
		foreach ($options as $key => $value) {
			$queryBuilder->where($key . ' = :' . $key);
		}
		$queryBuilder->values($options);

		$entities = [];
		foreach ($queryBuilder->getResults() as $result) {
			$entities[] = (new static())->injectEntityProperties($result);
		}

		return $entities;
	}

	/**
	 * Generate entity with form values
	 *
	 * @param array $values
	 * @return Entity
	 * @throws ReflectionException
	 * @throws \Exception
	 */
	public static function generateWithForm(array $values): Entity
	{
		$values['id'] = 0;
		return (new static())->injectEntityProperties($values);
	}

	/**
	 * Save(insert or update) current entity
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function save(): bool
	{
		if ($this->getId() == 0) {
			return $this->insert();
		} else {
			return $this->update();
		}
	}

	/**
	 * Create current entity
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function insert(): bool
	{
		$fields = static::getAllDatabaseFields();

		$queryBuilder = new QueryBuilder(QueryBuilder::QUERY_TYPE_INSERT);
		$queryBuilder->table(static::getTableName());
		$queryBuilder->fields($fields);
		$queryBuilder->values($this->retrieveEntityProperties());
		$result = $queryBuilder->execute();

		$this->setId($queryBuilder->getLastInsertId());

		return $result;
	}

	/**
	 * Update current entity
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function update(): bool
	{
		$fields = static::getAllDatabaseFields();

		$options = $this->retrieveEntityProperties();
		$options['id'] = $this->getId();

		$queryBuilder = new QueryBuilder(QueryBuilder::QUERY_TYPE_UPDATE);
		$queryBuilder->table(static::getTableName());
		$queryBuilder->fields($fields);
		$queryBuilder->where('id = :id');
		$queryBuilder->values($options);

		return $queryBuilder->execute();
	}

	/**
	 * Retrieve entity properties for PDO Execute
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function retrieveEntityProperties(): array
	{
		$results = [];

		$methods = static::getAllMethods(static::METHOD_TYPE_GET);

		/** @var ReflectionMethod $method */
		foreach ($methods as $method) {
			$methodName = $method->getName();
			$key = camelToSnakeCase(substr($methodName, 3));

			try {
				$reflectionClass = new ReflectionClass($method->getReturnType()->getName());
			} catch (ReflectionException $e) {
				$reflectionClass = null;
			}

			if (!is_null($reflectionClass)) { // Is object
				$className = $reflectionClass->getName();

				if ($className == 'DateTime') {
					/** @var \DateTime $var */
					$var = $this->$methodName();
					$results[$key] = is_null($var) ? null : $var->format('Y-m-d H:i:s');
				} else if (preg_match('/App__Entity/', str_replace('\\', '__', $className))) { // If $className contain App\Entity, that mean it's a local Entity, we need to find it
					/** @var Entity $entity2 */
					$entity2 = $this->$methodName();
					if (is_null($entity2)) {
						throw new \Exception(sprintf("%s::%s method find a %s with null value", static::class, $methodName, $className));
					}
					$results[$key] = $entity2->getId();
				} else {
					throw new \Exception(sprintf("Object type (%s) does not managed by this ORM actually", $className));
				}
			} else {
				$results[$key] = $this->$methodName();
			}
		}

		return $results;
	}

	/**
	 * Set current entity properties with array pdo result
	 *
	 * @param $results
	 * @return Entity|null
	 * @throws ReflectionException
	 * @throws \Exception
	 */
	private function injectEntityProperties($results): ?Entity
	{
		if (!is_array($results)) {
			return null;
		}

		$methods = static::getAllMethods(static::METHOD_TYPE_SET);

		/** @var ReflectionMethod $method */
		foreach ($methods as $method) {
			$methodName = $method->getName();
			$value = @$results[camelToSnakeCase(substr($methodName, 3))]; // @ for bypass the notice
			if (!isset($value)) {
				continue;
			}

			try {
				$reflectionClass = new ReflectionClass($method->getParameters()[0]->getType()->getName());
			} catch (ReflectionException $e) {
				$reflectionClass = null;
			}

			if (!is_null($reflectionClass)) { // need instantiable parameter
				$className = $reflectionClass->getName();

				if ($className == 'DateTime') {
					$this->$methodName(is_null($value) ? null : new $className($value));
				} else if (preg_match('/App__Entity/', str_replace('\\', '__', $className))) { // If $className contain App\Entity, that mean it's a local Entity, we need to find it
					/** @var Entity $className */
					$entity = $className::find($value);
					if (is_null($entity)) {
						throw new \Exception(sprintf("%s::%s method find a %s with null value", static::class, $methodName, $className));
					}
					$this->$methodName($entity);
				} else {
					throw new \Exception(sprintf("Instantiable type (%s) does not managed by this ORM actually", $className));
				}
			} else {
				$this->$methodName($value);
			}
		}

		return $this;
	}

	/**
	 * Parse php doc for get table name
	 *
	 * @return string
	 * @throws \Exception
	 */
	private static function getTableName(): string
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
	 */
	private static function getAllDatabaseFields(): array
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
	 * @throws \Exception
	 */
	private static function getAllMethods(string $type): array
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
<?php

namespace App\Framework\ORM;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

abstract class Entity
{
	public const SAFE_DELETE = false;
	public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';
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
	 * @param bool $byPassSafeDelete
	 * @return Entity|null
	 * @throws \Exception
	 */
	public static function find(int $id, bool $byPassSafeDelete = false): ?Entity
	{
		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table(static::getTableName());
		$queryBuilder->where('id = :id');
		if (static::SAFE_DELETE && !$byPassSafeDelete) {
			$queryBuilder->where('deleted_at IS NULL');
		}
		$queryBuilder->value($id, 'id');

		return (new static())->injectEntityProperties($queryBuilder->getResult());
	}

	/**
	 * Find one by something
	 *
	 * @param array $options
	 * @param bool $byPassSafeDelete
	 * @return Entity|null
	 * @throws \Exception
	 */
	public static function findOneBy(array $options = [], bool $byPassSafeDelete = false): ?Entity
	{
		if (empty($options)) {
			return null;
		}

		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table(static::getTableName());
		if (static::SAFE_DELETE && !$byPassSafeDelete) {
			$queryBuilder->where('deleted_at IS NULL');
		}

		foreach ($options as $key => $value) {
			$queryBuilder->where($key . ' = :' . $key);
		}
		$queryBuilder->values($options);

		return (new static())->injectEntityProperties($queryBuilder->getResult());
	}

	/**
	 * Find all
	 *
	 * @param bool $byPassSafeDelete
	 * @return entity[]
	 * @throws \Exception
	 */
	public static function all(bool $byPassSafeDelete = false): array
	{
		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table(static::getTableName());
		if (static::SAFE_DELETE && !$byPassSafeDelete) {
			$queryBuilder->where('deleted_at IS NULL');
		}

		$entities = [];
		foreach ($queryBuilder->getResults() as $result) {
			$entities[] = (new static())->injectEntityProperties($result);
		}

		return $entities;
	}

	/**
	 * Find all by something
	 *
	 * @param array $options
	 * @param bool $byPassSafeDelete
	 * @return entity[]
	 * @throws \Exception
	 */
	public static function findBy(array $options = [], bool $byPassSafeDelete = false): array
	{
		if (empty($options)) {
			return [];
		}

		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table(static::getTableName());
		if (static::SAFE_DELETE && !$byPassSafeDelete) {
			$queryBuilder->where('deleted_at IS NULL');
		}

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
	 * Delete current entity from table
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function delete(): bool
	{
		$options = ['id' => $this->getId()];

		if (static::SAFE_DELETE) {
			$options['deleted_at'] = (new \DateTime())->format(self::DATE_TIME_FORMAT);
		}

		$queryBuilder = new QueryBuilder(static::SAFE_DELETE ? QueryBuilder::QUERY_TYPE_UPDATE : QueryBuilder::QUERY_TYPE_DELETE);
		$queryBuilder->table(static::getTableName());
		$queryBuilder->field('deleted_at');
		$queryBuilder->values($options);
		$queryBuilder->where('id = :id');

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
					$results[$key] = is_null($var) ? null : $var->format(self::DATE_TIME_FORMAT);
				} else if (preg_match('/App__Entity/', str_replace('\\', '__', $className))) { // If $className contain App\Entity, that mean it's a local Entity, we need to find it
					$key = $key . '_id'; //@Todo Trouver une autre façon de rajouter le _id
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
			$resultsKey = camelToSnakeCase(substr($methodName, 3));

			try {
				$reflectionClass = new ReflectionClass($method->getParameters()[0]->getType()->getName());
				$className = $reflectionClass->getName();
				$isEntity = preg_match('/App__Entity/', str_replace('\\', '__', $className));
			} catch (ReflectionException $e) {
				$reflectionClass = null;
				$className = null;
				$isEntity = false;
			}

			$value = @$results[$resultsKey]; // @ for bypass the notice
			if ($isEntity) {
				$value = @$results[($resultsKey . '_id')]; // @ for bypass the notice
			}

			if (!isset($value)) {
				continue;
			}

			if (!is_null($reflectionClass) && !is_null($className)) { // need instantiable parameter
				if ($className == 'DateTime') {
					$this->$methodName(is_null($value) ? null : new \DateTime($value));
				} else if ($isEntity) { // If $className contain App\Entity, that mean it's a local Entity, we need to find it
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
	 * @return ReflectionMethod[]
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
				if ($type !== static::METHOD_TYPE_GET || $method->getName() != 'getId') {
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
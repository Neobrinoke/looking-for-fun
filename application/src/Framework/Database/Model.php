<?php

namespace App\Framework\Database;

use App\Framework\Database\QueryBuilder\SelectQueryBuilder;
use App\Framework\Support\Collection;

class Model
{
	public const TABLE = 'undefined';
	public const SAFE_DELETE = false;
	public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

	/**
	 * Create new query builder.
	 *
	 * @param null|string $class
	 * @return SelectQueryBuilder
	 */
	public static function query(?string $class = null): SelectQueryBuilder
	{
		return new SelectQueryBuilder($class ?? static::class);
	}

	/**
	 * Retrieve first element.
	 *
	 * @return Model|null
	 * @throws \Exception
	 */
	public static function first(): ?Model
	{
		return self::query()->getResult();
	}

	/**
	 * Find one by id
	 *
	 * @param int $id
	 * @return Model|null
	 * @throws \Exception
	 */
	public static function find(int $id): ?Model
	{
		return self::query()
			->where('id = :id')
			->value($id, 'id')
			->getResult();
	}

	/**
	 * Find one by something
	 *
	 * @param array $options
	 * @return Model|null
	 * @throws \Exception
	 */
	public static function findOneBy(array $options): ?Model
	{
		$queryBuilder = self::query();

		foreach ($options as $key => $value) {
			$queryBuilder->where($key . ' = :' . $key);
		}

		$queryBuilder->values($options);

		return $queryBuilder->getResult();
	}

	/**
	 * Retrieve all elements.
	 *
	 * @param array $ordersBy
	 * @return Collection
	 * @throws \Exception
	 */
	public static function all(array $ordersBy = []): Collection
	{
		return new Collection(self::query()
			->ordersBy($ordersBy)
			->getResults()
		);
	}

	/**
	 * Find all by something
	 * Return array of entity or empty array if no records found
	 *
	 * @param array $options
	 * @param array $ordersBy
	 * @return Collection
	 * @throws \Exception
	 */
	public static function findBy(array $options, array $ordersBy = []): Collection
	{
		$queryBuilder = self::query()
			->values($options)
			->ordersBy($ordersBy);

		foreach ($options as $key => $value) {
			$queryBuilder->where($key . ' = :' . $key);
		}

		return new Collection($queryBuilder->getResults());
	}

	/**
	 * Get hasOne relation.
	 *
	 * @param string $related
	 * @param string $foreignKey
	 * @param string $localKey
	 * @return Model|mixed
	 * @throws \Exception
	 */
	protected function hasOne(string $related, string $foreignKey, string $localKey): Collection
	{
		return self::query($related)
			->where(sprintf("%s = ?", $localKey))
			->value($this->$foreignKey)
			->getResult();
	}

	/**
	 * Get hasOne relation.
	 *
	 * @param string $related
	 * @param string $foreignKey
	 * @param string $localKey
	 * @return Model|mixed
	 * @throws \Exception
	 */
	protected function hasMany(string $related, string $foreignKey, string $localKey): Collection
	{
		return new Collection(self::query($related)
			->where(sprintf("%s = ?", $localKey))
			->value($this->$foreignKey)
			->getResults()
		);
	}
}
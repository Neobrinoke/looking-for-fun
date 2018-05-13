<?php

namespace App\Framework\Database\QueryBuilder;

class SelectQueryBuilder extends QueryBuilder
{
	/**
	 * SelectQueryBuilder constructor.
	 *
	 * @param $modelClassName
	 */
	public function __construct($modelClassName = null)
	{
		parent::__construct($modelClassName);
		$this->type = self::QUERY_TYPE_SELECT;
		$this->fields = ['*'];
	}
}
<?php

namespace Framework;

use App\Framework\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
	public function testSelectFrom()
	{
		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table('users');

		$this->assertEquals('SELECT * FROM users', $queryBuilder->getQuery());
	}

	public function testSelectFromWithCloseWhere()
	{
		$queryBuilder = new QueryBuilder();
		$queryBuilder->field('*');
		$queryBuilder->table('users');
		$queryBuilder->where('id = :id');

		$this->assertEquals('SELECT * FROM users WHERE id = :id', $queryBuilder->getQuery());
	}

	public function testInsertInto()
	{
		$queryBuilder = new QueryBuilder(QueryBuilder::QUERY_TYPE_INSERT);
		$queryBuilder->table('users');
		$queryBuilder->fields(['name', 'login']);

		$this->assertEquals('INSERT INTO users (name, login) VALUES (:name, :login)', $queryBuilder->getQuery());
	}

	public function testUpdate()
	{
		$queryBuilder = new QueryBuilder(QueryBuilder::QUERY_TYPE_UPDATE);
		$queryBuilder->table('users');
		$queryBuilder->fields(['name', 'login']);

		$this->assertEquals('UPDATE users SET name = :name, login = :login', $queryBuilder->getQuery());
	}

	public function testUpdateWithCloseWhere()
	{
		$queryBuilder = new QueryBuilder(QueryBuilder::QUERY_TYPE_UPDATE);
		$queryBuilder->table('users');
		$queryBuilder->fields(['name', 'login']);
		$queryBuilder->where('id = :id');

		$this->assertEquals('UPDATE users SET name = :name, login = :login WHERE id = :id', $queryBuilder->getQuery());
	}

	public function testSelectWithOrderBy()
	{
		$queryBuilder = new QueryBuilder(QueryBuilder::QUERY_TYPE_SELECT);
		$queryBuilder->table('users');
		$queryBuilder->field('*');
		$queryBuilder->orderBy('name', 'ASC');
		$queryBuilder->orderBy('login', 'DESC');

		$this->assertEquals('SELECT * FROM users ORDER BY name ASC, login DESC', $queryBuilder->getQuery());
	}

	public function testQueryBuilderWithWrongQueryType()
	{
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Invalid query builder type');

		$queryBuilder = new QueryBuilder('test');
		$queryBuilder->getQuery();
	}
}
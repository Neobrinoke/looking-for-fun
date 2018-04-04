<?php

namespace Framework;

use App\Framework\Database\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
	public function testSelect()
	{
		$queryBuilder = (new QueryBuilder())
			->select()
			->field('*')
			->table('users');

		$this->assertEquals('SELECT * FROM users', $queryBuilder->getQuery());
	}

	public function testSelectWithCloseWhere()
	{
		$queryBuilder = (new QueryBuilder())
			->select()
			->field('*')
			->table('users')
			->where('id = :id');

		$this->assertEquals('SELECT * FROM users WHERE id = :id', $queryBuilder->getQuery());
	}

	public function testInsert()
	{
		$queryBuilder = (new QueryBuilder())
			->insert()
			->table('users')
			->fields(['name', 'login']);

		$this->assertEquals('INSERT INTO users (name, login) VALUES (:name, :login)', $queryBuilder->getQuery());
	}

	public function testUpdate()
	{
		$queryBuilder = (new QueryBuilder())
			->update()
			->table('users')
			->fields(['name', 'login']);

		$this->assertEquals('UPDATE users SET name = :name, login = :login', $queryBuilder->getQuery());
	}

	public function testUpdateWithCloseWhere()
	{
		$queryBuilder = (new QueryBuilder())
			->update()
			->table('users')
			->fields(['name', 'login'])
			->where('id = :id');

		$this->assertEquals('UPDATE users SET name = :name, login = :login WHERE id = :id', $queryBuilder->getQuery());
	}

	public function testDelete()
	{
		$queryBuilder = (new QueryBuilder())
			->delete()
			->table('users');

		$this->assertEquals('DELETE FROM users', $queryBuilder->getQuery());
	}

	public function testDeleteWithCloseWhere()
	{
		$queryBuilder = (new QueryBuilder())
			->delete()
			->table('users')
			->where('id = :id');

		$this->assertEquals('DELETE FROM users WHERE id = :id', $queryBuilder->getQuery());
	}

	public function testSelectWithOrderBy()
	{
		$queryBuilder = (new QueryBuilder())
			->select()
			->table('users')
			->field('*')
			->orderBy('name', 'ASC')
			->orderBy('login', 'DESC');

		$this->assertEquals('SELECT * FROM users ORDER BY name ASC, login DESC', $queryBuilder->getQuery());
	}

	public function testSelectWithOrdersBy()
	{
		$queryBuilder = (new QueryBuilder())
			->select()
			->table('users')
			->field('*')
			->ordersBy([
				'name ASC',
				'login DESC'
			]);

		$this->assertEquals('SELECT * FROM users ORDER BY name ASC, login DESC', $queryBuilder->getQuery());
	}
}
<?php

use App\Framework\Database\Migration;

class CreateUsersTable extends Migration
{
	public function change()
	{
		$this->table('users')
			->addColumn('name', 'string')
			->addColumn('login', 'string')
			->addColumn('password', 'string')
			->addColumn('email', 'string')
			->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
			->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
			->addColumn('deleted_at', 'datetime', ['null' => true, 'default' => null])
			->create();
	}
}

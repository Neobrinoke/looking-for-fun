<?php

use App\Framework\Database\Migration;

class CreateGameGroupsTable extends Migration
{
	public function up()
	{
		$this->table('game_groups', ['signed' => false])
			->addColumn('name', 'string')
			->addColumn('description', 'text')
			->addColumn('owner_id', 'integer', ['signed' => false])
			->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
			->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
			->addColumn('deleted_at', 'datetime', ['null' => true, 'default' => null])
			->addForeignKey('owner_id', 'users', 'id', ['delete' => 'cascade'])
			->create();
	}

	public function down()
	{
		$this->table('game_groups')->drop();
	}
}
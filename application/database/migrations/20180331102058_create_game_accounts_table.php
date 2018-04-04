<?php

use App\Framework\Database\Migration;

class CreateGameAccountsTable extends Migration
{
	public function up()
	{
		$this->table('game_accounts', ['signed' => false])
			->addColumn('user_id', 'integer', ['signed' => false])
			->addColumn('player_name', 'string')
			->addColumn('server_location', 'string')
			->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
			->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
			->addColumn('deleted_at', 'datetime', ['null' => true, 'default' => null])
			->addForeignKey('user_id', 'users', 'id', ['delete' => 'cascade'])
			->create();
	}

	public function down()
	{
		$this->table('game_accounts')->drop();
	}
}
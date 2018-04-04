<?php

use App\Framework\Database\Migration;

class CreateGameGroupsUsersTable extends Migration
{
	public function up()
	{
		$this->table('game_groups_users', ['signed' => false])
			->addColumn('user_id', 'integer', ['signed' => false])
			->addColumn('game_group_id', 'integer', ['signed' => false])
			->addForeignKey('user_id', 'users', 'id', ['delete' => 'cascade'])
			->addForeignKey('game_group_id', 'game_groups', 'id', ['delete' => 'cascade'])
			->create();
	}

	public function down()
	{
		$this->table('game_groups_users')->drop();
	}
}
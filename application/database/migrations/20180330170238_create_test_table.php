<?php

use App\Framework\Database\Migration;

class CreateTestTable extends Migration
{
	public function change()
	{
		$this->table('tests')
			->addColumn('name', 'string')
			->addColumn('slug', 'string')
			->create();
	}
}

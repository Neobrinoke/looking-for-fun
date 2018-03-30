<?php

use App\Framework\Database\Seeder;

class UserSeeder extends Seeder
{
	public function run()
	{
		$datas = [];
		for ($i = 0; $i < 100; $i++) {
			$datas[] = [
				'name' => 'name' . $i,
				'login' => 'login' . $i,
				'email' => 'email' . $i . '@gmail.com',
				'password' => 'password' . $i,
			];
		}

		$this->table('users')
			->insert($datas)
			->save();
	}
}

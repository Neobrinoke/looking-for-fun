<?php

use App\Framework\Database\Seeder;

class TestSeeder extends Seeder
{
	public function run()
	{
		$user = new \App\Entity\User();
		$user->setName('name');
		$user->setEmail('email@email.fr');
		$user->setLogin('login');
		$user->setPassword('password');
		$user->save();

		for ($i = 0; $i < 100; $i++) {
			$gameGroup = new \App\Entity\GameGroup();
			$gameGroup->setName('name ' . $i);
			$gameGroup->setDescription('description ' . $i);
			$gameGroup->setOwner($user);
			$gameGroup->save();
		}
	}
}

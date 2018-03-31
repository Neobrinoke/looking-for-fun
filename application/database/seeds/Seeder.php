<?php

use App\Framework\Database\Seeder as Seed;

class Seeder extends Seed
{
	public function run()
	{
		$faker = \Faker\Factory::create();

		$users = [];
		for ($i = 0; $i < 10; $i++) {
			$user = new \App\Entity\User();
			$user->setName($faker->name);
			$user->setEmail($faker->email);
			$user->setLogin($faker->userName);
			$user->setPassword($faker->password);
			$user->save();

			$users[] = $user;
		}

		foreach ($users as $user) {
			for ($i = 0; $i < 10; $i++) {
				$date = $faker->dateTime;

				$gameGroup = new \App\Entity\GameGroup();
				$gameGroup->setName($faker->name);
				$gameGroup->setDescription($faker->text);
				$gameGroup->setOwner($user);
				$gameGroup->setCreatedAt($date);
				$gameGroup->setUpdatedAt($date);
				$gameGroup->save();
			}
		}
	}
}
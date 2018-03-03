<?php

namespace App\Controller;

use App\Entity\AccountGame;
use App\Entity\GameGroup;
use App\Entity\GameGroupUser;
use App\Entity\GroupGame;
use App\Entity\User;
use App\Repository\GameAccountRepository;
use App\Repository\UserRepository;

class Controller
{
	public function indexAction()
	{
//		$oUserRepository = new UserRepository();
//		$user = $oUserRepository->findById(1);

//		$gameAccountRepository = new GameAccountRepository();
//		$gameAccount = $gameAccountRepository->findById(1);

//		include(__DIR__ . '/../../resources/view/default/default.php');

//
//		$user = User::find(1);
//		var_dump($user);
//		$user->save();
//
//
//		$user = new User();
//		$user->save();

//		var_dump(User::all());

//		var_dump(User::findBy([
//			'name' => 'dqsdqsdqsdqsd'
//		]));



		$user = new User();

		$user->setEmail('email@test.fr');
		$user->setName('name');

		var_dump($user->save());

		var_dump($user);
	}
}
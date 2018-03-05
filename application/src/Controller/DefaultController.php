<?php

namespace App\Controller;

use App\Entity\User;

class DefaultController extends Controller
{
	public function homeAction()
	{
		return $this->renderView('default.default');
	}

	public function testAction($id)
	{
		/** @var User $user */
		$user = User::find($id);
		var_dump($user);
		return $this->response();
	}
}
<?php

namespace App\Controller;

class SecurityController extends Controller
{
	public function loginAction()
	{
		return $this->renderView('security.login');
	}

	public function registerAction()
	{
		return $this->renderView('security.register');
	}
}
<?php

namespace App\Middleware;

use App\Framework\Middleware\Middleware;

class Auth extends Middleware
{
	public function handle()
	{
		if (!$this->auth()->isLogged()) {
			return $this->redirectToRoute('security.login');
		}

		return true;
	}
}
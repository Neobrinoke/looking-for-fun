<?php

namespace App\Middleware;

use App\Framework\Middleware\Middleware;

class CheckLogin extends Middleware
{
	public function handle()
	{
		if (!$this->auth()->isLogged()) {
			return $this->redirectToRoute('security.login');
		}

		return true;
	}
}
<?php

namespace App\Middleware;

use App\Framework\Middleware\Middleware;

class Auth extends Middleware
{
	/**
	 * Redirect to login if auth is not logged
	 *
	 * @return bool|\GuzzleHttp\Psr7\Response
	 * @throws \Exception
	 */
	public function handle()
	{
		if (!$this->auth()->isLogged()) {
			return $this->redirectToRoute('security.login');
		}

		return true;
	}
}
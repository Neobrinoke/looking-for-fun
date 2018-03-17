<?php

namespace App\Middleware;

use App\Framework\Middleware\Middleware;

class Guest extends Middleware
{
	/**
	 * Redirect to home page if auth is logged
	 *
	 * @return bool|\GuzzleHttp\Psr7\Response
	 * @throws \Exception
	 */
	public function handle()
	{
		if ($this->auth()->isLogged()) {
			return $this->redirectToRoute('home');
		}

		return true;
	}
}
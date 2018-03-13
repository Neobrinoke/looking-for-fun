<?php

namespace App\Middleware;

use App\Framework\Middleware\Middleware;

class Guest extends Middleware
{
	public function handle()
	{
		if ($this->auth()->isLogged()) {
			return $this->redirectToRoute('home');
		}

		return true;
	}
}
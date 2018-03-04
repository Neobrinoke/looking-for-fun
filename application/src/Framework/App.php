<?php

namespace App\Framework;

use App\Framework\Router\Router;

class App
{
	/**
	 * @param string $url
	 * @return string
	 */
	public function run(string $url): string
	{
		if (!empty($url) && $url !== "/" && $url[-1] === "/") {
			header('Location: ' . substr($url, 0, -1) . '');
		}
		return Router::run($url);
	}
}
<?php

namespace App\Framework;

class App
{
	public function run(string $url): string
	{
		if (!empty($url) && $url !== "/" && $url[-1] === "/") {
			header('Location: ' . substr($url, 0, -1) . '');
			return '';
		}

		$route = Router::match($url);
		if (!is_null($route)) {
			return call_user_func_array($route->getCallback(), array_values($route->getParams()));
		}

		return '<h1>Error 404</h1>';
	}
}
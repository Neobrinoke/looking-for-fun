<?php

namespace App\Framework;

use App\Framework\Http\Request;
use App\Framework\Http\Response;
use App\Framework\Router\Route;
use josegonzalez\Dotenv\Loader;

class App
{
	/**
	 * App constructor.
	 * @throws \Exception
	 */
	public function __construct()
	{
		$envFile = __DIR__ . '/../../.env';

		if (!file_exists($envFile)) {
			throw new \Exception('Dot file env does not exist');
		}

		(new Loader($envFile))->parse()->putenv(true);
	}

	/**
	 * Run the main application
	 *
	 * @param Request $request
	 * @return Response
	 * @throws \Exception
	 */
	public function run(Request $request): Response
	{
		$uri = $request->getUri()->getPath();
		if (!empty($uri) && $uri !== "/" && $uri[-1] === "/") {
			return new Response(301, ['Location' => substr($uri, 0, -1)]);
		}

		/** @var Route $route */
		$route = router()->run($request);
		if (!is_null($route)) {
			$response = $route->call($uri);
			if (is_string($response)) {
				return new Response(200, [], $response);
			} else if ($response instanceof Response) {
				return $response;
			} else {
				throw new \Exception('Invalid response');
			}
		}

		return new Response(404, [], '<h1>Erreur 404</h1>');
	}
}
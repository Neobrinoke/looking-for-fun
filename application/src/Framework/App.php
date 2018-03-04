<?php

namespace App\Framework;

use App\Framework\Router\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
	/** @var Router */
	public $router;

	/**
	 * App constructor.
	 */
	public function __construct()
	{
		$this->router = new Router();
	}

	/**
	 * Run the main application
	 *
	 * @param ServerRequestInterface $request
	 * @return ResponseInterface
	 * @throws \Exception
	 */
	public function run(ServerRequestInterface $request): ResponseInterface
	{
		$uri = $request->getUri()->getPath();
		if (!empty($uri) && $uri !== "/" && $uri[-1] === "/") {
			return new Response(301, ['Location' => substr($uri, 0, -1)]);
		}

		$route = $this->router->run($request);
		if (!is_null($route)) {
			$response = $route->call();
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

	/**
	 * Send info on the browser
	 *
	 * @param ResponseInterface $response
	 */
	public static function send(ResponseInterface $response)
	{
		$http_line = sprintf('HTTP/%s %s %s',
			$response->getProtocolVersion(),
			$response->getStatusCode(),
			$response->getReasonPhrase()
		);

		header($http_line, true, $response->getStatusCode());

		foreach ($response->getHeaders() as $name => $values) {
			foreach ($values as $value) {
				header("$name: $value", false);
			}
		}

		$stream = $response->getBody();

		if ($stream->isSeekable()) {
			$stream->rewind();
		}

		while (!$stream->eof()) {
			echo $stream->read(1024 * 8);
		}
	}
}
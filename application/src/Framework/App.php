<?php

namespace App\Framework;

use App\Framework\Router\Route;
use App\Framework\Router\Router;
use DI\ContainerBuilder;
use GuzzleHttp\Psr7\Response;
use josegonzalez\Dotenv\Loader;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
	/** @var ContainerInterface */
	public $container;

	/**
	 * App constructor.
	 * @param ContainerInterface $container
	 * @throws \Exception
	 */
	public function __construct(ContainerInterface $container = null)
	{
		if (is_null($container)) {
			$container = (new ContainerBuilder())->build();
		}
		$this->container = $container;
	}

	/**
	 * Run the main application
	 *
	 * @param ServerRequestInterface $request
	 * @return ResponseInterface
	 * @throws \Exception
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
	public function run(ServerRequestInterface $request): ResponseInterface
	{
		$envFile = __DIR__ . '/../../.env';

		if (!file_exists($envFile)) {
			throw new \Exception('Dot file env does not exist');
		}

		(new Loader($envFile))->parse()->putenv(true);

		$uri = $request->getUri()->getPath();
		if (!empty($uri) && $uri !== "/" && $uri[-1] === "/") {
			return new Response(301, ['Location' => substr($uri, 0, -1)]);
		}

		/** @var Route $route */
		$route = $this->container->get(Router::class)->run($request);
		if (!is_null($route)) {
			$response = $route->call($this->container, $uri);
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
	 * Send response on the browser
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
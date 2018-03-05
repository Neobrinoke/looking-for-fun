<?php

namespace App\Controller;

use App\Framework\Renderer\Renderer;
use App\Framework\Router\Router;
use GuzzleHttp\Psr7\Response;

class Controller
{
	/** @var Router */
	private $router;

	/** @var Renderer */
	private $renderer;

	/**
	 * Controller constructor.
	 *
	 * @param Router $router
	 */
	public function __construct(Router $router)
	{
		$this->router = $router;
		$this->renderer = new Renderer($router);
	}

	/**
	 * Send new response
	 *
	 * @param null|string $body
	 * @param int $status
	 * @param array $headers
	 * @return Response
	 */
	protected function response(?string $body = null, int $status = 200, array $headers = [])
	{
		return new Response($status, $headers, $body);
	}

	/**
	 * Redirect to route
	 *
	 * @param string $url
	 * @return Response
	 */
	protected function redirect(string $url)
	{
		return new Response(301, ['Location' => $url]);
	}

	/**
	 * Generate path for url
	 *
	 * @param string $name
	 * @param array $params
	 * @return Router
	 * @throws \Exception
	 */
	protected function path(string $name, array $params = [])
	{
		return $this->router->generateUri($name, $params);
	}

	/**
	 * Generate view
	 *
	 * @param string $view
	 * @param array $params
	 * @return Response
	 */
	protected function renderView(string $view, array $params = [])
	{
		return $this->response($this->renderer->renderView($view, $params));
	}
}
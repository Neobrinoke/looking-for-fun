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
	 * @param Renderer $renderer
	 */
	public function __construct(Router $router, Renderer $renderer)
	{
		$this->router = $router;
		$this->renderer = $renderer;
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
	 * Redirect to route
	 *
	 * @param string $route
	 * @param array $params
	 * @return Response
	 * @throws \Exception
	 */
	protected function redirectToRoute(string $route, array $params = [])
	{
		return $this->redirect($this->generateUri($route, $params));
	}

	/**
	 * Generate uri for route
	 *
	 * @param string $route
	 * @param array $params
	 * @return Router
	 * @throws \Exception
	 */
	protected function generateUri(string $route, array $params = [])
	{
		return $this->router->generateUri($route, $params);
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
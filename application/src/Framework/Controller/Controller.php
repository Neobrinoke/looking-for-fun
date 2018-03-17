<?php

namespace App\Framework\Controller;

use App\Framework\Authentication\Auth;
use App\Framework\Renderer\Renderer;
use App\Framework\Router\Router;
use App\Framework\Session\Session;
use GuzzleHttp\Psr7\Response;

class Controller
{
	/** @var Router */
	private $router;

	/** @var Renderer */
	private $renderer;

	/** @var Session */
	private $session;

	/** @var Auth */
	private $auth;

	/**
	 * Controller constructor.
	 *
	 * @param Router $router
	 * @param Renderer $renderer
	 * @param Session $session
	 * @param Auth $auth
	 */
	public function __construct(Router $router, Renderer $renderer, Session $session, Auth $auth)
	{
		$this->router = $router;
		$this->renderer = $renderer;
		$this->session = $session;
		$this->auth = $auth;
	}

	/**
	 * Send new response
	 *
	 * @param null|string $body
	 * @param int $status
	 * @param array $headers
	 * @return Response
	 */
	protected function response(?string $body = null, int $status = 200, array $headers = []): Response
	{
		return new Response($status, $headers, $body);
	}

	/**
	 * Redirect to route
	 *
	 * @param string $url
	 * @return Response
	 */
	protected function redirect(string $url): Response
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
	protected function redirectToRoute(string $route, array $params = []): Response
	{
		return $this->redirect($this->generateUri($route, $params));
	}

	/**
	 * Generate uri for route
	 *
	 * @param string $route
	 * @param array $params
	 * @return string
	 * @throws \Exception
	 */
	protected function generateUri(string $route, array $params = []): string
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
	protected function renderView(string $view, array $params = []): Response
	{
		return $this->response($this->renderer->renderView($view, $params));
	}

	/**
	 * Retrieve session instance
	 *
	 * @return Session
	 */
	protected function session(): Session
	{
		return $this->session;
	}

	/**
	 * Retrieve auth instance
	 *
	 * @return Auth
	 */
	protected function auth(): Auth
	{
		return $this->auth;
	}
}
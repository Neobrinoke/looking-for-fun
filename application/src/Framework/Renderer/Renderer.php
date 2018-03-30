<?php

namespace App\Framework\Renderer;

use App\Framework\Authentication\Auth;
use App\Framework\Router\Router;
use App\Framework\Session\Session;

class Renderer
{
	public const BASE_DIR_VIEWS = __DIR__ . '/../../../resources/view/';

	/** @var Router */
	private $router;

	/** @var Session */
	private $session;

	/** @var Auth */
	private $auth;

	/**
	 * Renderer constructor.
	 *
	 * @param Router $router
	 * @param Session $session
	 * @param Auth $auth
	 */
	public function __construct(Router $router, Session $session, Auth $auth)
	{
		$this->router = $router;
		$this->session = $session;
		$this->auth = $auth;
	}

	/**
	 * Render view with params
	 *
	 * @param string $view
	 * @param array $params
	 * @return string
	 */
	public function renderView(string $view, array $params = []): string
	{
		$params['errors'] = $params['errors'] ?? [];
		$params['old'] = $params['old'] ?? [];

		ob_start();
		extract($params);
		require(self::BASE_DIR_VIEWS . str_replace('.', '/', $view) . '.php');
		return ob_get_clean();
	}
}
<?php

namespace App\Framework\Renderer;

use App\Framework\Router\Router;

class Renderer
{
	public const BASE_DIR_VIEWS = __DIR__ . '/../../../resources/view/';

	/** @var Router */
	private $router;

	/**
	 * Renderer constructor.
	 *
	 * @param Router $router
	 */
	public function __construct(Router $router)
	{
		$this->router = $router;
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
		$params['renderer'] = $this;
		$params['router'] = $this->router;
		ob_start();
		extract($params);
		require(self::BASE_DIR_VIEWS . str_replace('.', '/', $view) . '.php');
		return ob_get_clean();
	}
}
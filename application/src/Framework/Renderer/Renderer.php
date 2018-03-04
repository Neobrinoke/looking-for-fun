<?php

namespace App\Framework\Renderer;

class Renderer
{
	public const BASE_DIR_VIEWS = __DIR__ . '/../../../resources/view/';

	public function renderView(string $view, array $params = []): string
	{
		$params['renderer'] = $this;
		ob_start();
		extract($params);
		require(self::BASE_DIR_VIEWS . str_replace('.', '/', $view) . '.php');
		return ob_get_clean();
	}
}
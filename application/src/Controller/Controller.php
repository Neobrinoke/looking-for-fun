<?php

namespace App\Controller;

use App\Framework\Renderer;

class Controller extends Renderer
{
	public function indexAction()
	{
		return $this->renderView('default.default');
	}
}
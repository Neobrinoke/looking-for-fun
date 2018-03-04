<?php

namespace App\Controller;

class DefaultController extends Controller
{
	public function homeAction()
	{
		return $this->renderView('default.default');
	}

	public function testAction($id)
	{
		return "Je suis l'article $id";
	}
}
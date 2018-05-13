<?php

namespace App\Controller;

use App\Framework\Controller\Controller;
use App\Framework\Http\Response;

class DefaultController extends Controller
{
	/**
	 * @return Response
	 */
	public function homeAction()
	{
		return $this->renderView('default.default');
	}

	/**
	 * @return Response
	 */
	public function testAction()
	{
		return new Response();
	}
}
<?php

namespace App\Controller;

use App\Entity\User;
use Psr\Http\Message\ServerRequestInterface;

class DefaultController extends Controller
{
	/**
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function homeAction()
	{
		return $this->renderView('default.default');
	}

	/**
	 * @param $id
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function testAction($id)
	{
		return $this->renderView('default.test', compact('id'));
	}

	/**
	 * @param ServerRequestInterface $request
	 * @param $id
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function storeAction(ServerRequestInterface $request, $id)
	{
		return $this->renderView('default.test', compact('id'));
	}
}
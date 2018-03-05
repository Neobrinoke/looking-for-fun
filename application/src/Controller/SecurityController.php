<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface;

class SecurityController extends Controller
{
	/**
	 * Show form for login
	 *
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function loginAction()
	{
		return $this->renderView('security.login');
	}

	/**
	 * Show form for register
	 *
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function registerAction()
	{
		return $this->renderView('security.register');
	}

	/**
	 * Store the register request
	 *
	 * @param ServerRequestInterface $request
	 * @return \GuzzleHttp\Psr7\Response
	 * @throws \Exception
	 */
	public function storeAction(ServerRequestInterface $request)
	{
		$old = $request->getParsedBody();
		return $this->renderView('security.register', compact('old'));
	}
}
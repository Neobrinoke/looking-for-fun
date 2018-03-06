<?php

namespace App\Controller;

use App\Entity\User;
use App\Framework\Validator\Validator;
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

		$validator = new Validator($request->getParsedBody(), [
			'name' => 'min:3|required',
			'login' => 'min:3|required',
			'email' => 'email|required',
			'password' => 'password|required'
		]);

		$errors = $validator->validate();

		if (empty($errors)) {
			$user = User::generateWithForm($request->getParsedBody());
			$user->save();
			return $this->redirectToRoute('home');
		}

		return $this->renderView('security.register', compact('old', 'errors'));
	}
}
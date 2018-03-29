<?php

namespace App\Controller;

use App\Entity\User;
use App\Framework\Controller\Controller;
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
	 * Show form for login
	 *
	 * @param ServerRequestInterface $request
	 * @return \GuzzleHttp\Psr7\Response
	 * @throws \Exception
	 */
	public function loginCheckAction(ServerRequestInterface $request)
	{
		$old = $request->getParsedBody();

		$validator = new Validator($request->getParsedBody(), [
			'login' => 'min:3|required',
			'password' => 'required'
		]);

		if ($validator->validate()) {
			/** @var User $user */
			$user = User::findOneBy([
				'login' => $request->getParsedBody()['login'],
				'password' => $request->getParsedBody()['password']
			]);

			if (!is_null($user)) {
				$this->auth()->initUser($user);

				if ($this->session()->has('last_uri')) {
					return $this->redirect($this->session()->getFlash('last_uri'));
				}

				return $this->redirectToRoute('home');
			}
			$errors[] = 'Utilisateur introuvable';
		}

		$errors = $errors ?? $validator->getErrors();

		return $this->renderView('security.login', compact('old', 'errors'));
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
			'login' => 'min:3|required|unique:User',
			'email' => 'email|required|unique:User',
			'password' => 'min:8|confirm|required'
		]);

		if ($validator->validate()) {
			/** @var User $user */
			$user = User::generateWithForm($request->getParsedBody());
			$user->save();

			$this->auth()->initUser($user);

			if ($this->session()->has('last_uri')) {
				return $this->redirect($this->session()->getFlash('last_uri'));
			}

			return $this->redirectToRoute('home');
		}

		$errors = $validator->getErrors();

		return $this->renderView('security.register', compact('old', 'errors'));
	}

	/**
	 * Logout current user
	 * @throws \Exception
	 */
	public function logoutAction()
	{
		$this->auth()->logout();
		return $this->redirectToRoute('home');
	}
}
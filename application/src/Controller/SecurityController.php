<?php

namespace App\Controller;

use App\Entity\User;
use App\Framework\Controller\Controller;
use App\Framework\Http\Request;
use App\Framework\Http\Response;
use App\Framework\Support\Collection;
use App\Framework\Validator\Validator;

class SecurityController extends Controller
{
	/**
	 * Show form for login
	 *
	 * @return Response
	 */
	public function loginAction()
	{
		return $this->renderView('security.login');
	}

	/**
	 * Show form for login
	 *
	 * @param Request $request
	 * @return Response
	 * @throws \Exception
	 */
	public function loginCheckAction(Request $request)
	{
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
			$validator->getErrors()->add('Utilisateur introuvable');
		}

		$errors = $validator->getErrors();

		return $this->renderView('security.login', compact('errors'));
	}

	/**
	 * Show form for register
	 *
	 * @return Response
	 */
	public function registerAction()
	{
		return $this->renderView('security.register');
	}

	/**
	 * Store the register request
	 *
	 * @param Request $request
	 * @return Response
	 * @throws \Exception
	 */
	public function storeAction(Request $request)
	{
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

		return $this->renderView('security.register', compact('errors'));
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
<?php

namespace App\Framework\Authentication;

use App\Entity\User;
use App\Framework\Session\Session;

class Auth
{
	/** @var Session */
	private $session;

	/**
	 * Auth constructor.
	 *
	 * @param Session $session
	 */
	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	/**
	 * Initialize logged user
	 *
	 * @param User $user
	 */
	public function initUser(User $user)
	{
		$this->session->set('user_id', $user->getId());
	}

	/**
	 * Return current logged user
	 *
	 * @return User
	 * @throws \Exception
	 * @throws \ReflectionException
	 */
	public function user()
	{
		if (!$this->isLogged()) {
			return null;
		}

		/** @var User $user */
		$user = User::find($this->session->get('user_id'));
		return $user;
	}

	/**
	 * Check if user is logged
	 *
	 * @return bool
	 */
	public function isLogged()
	{
		return $this->session->has('user_id');
	}

	/**
	 * Logout current user
	 */
	public function logout()
	{
		$this->session->remove('user_id');
	}
}
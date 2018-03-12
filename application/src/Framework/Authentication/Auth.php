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
		$this->session->set('user', $user);
	}

	/**
	 * Return current logged user
	 *
	 * @return User
	 */
	public function user()
	{
		if (!$this->isLogged()) {
			return null;
		}

		return $this->session->get('user');
	}

	/**
	 * Check if user is logged
	 *
	 * @return bool
	 */
	public function isLogged()
	{
		return is_null($this->session->get('user')) ? false : true;
	}
}
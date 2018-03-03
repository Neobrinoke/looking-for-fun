<?php

namespace App\Entity;

class GameGroupUser extends Entity
{
	/** @var int */
	private $id;

	/** @var User|null */
	private $user;

	/** @var GameGroup|null */
	private $gameGroup;

	/**
	 * GameGroupUser constructor.
	 */
	public function __construct()
	{
		$this->setId(0);
		$this->setUser(null);
		$this->setGameGroup(null);
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId(int $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return User|null
	 */
	public function getUser(): ?User
	{
		return $this->user;
	}

	/**
	 * @param User|null $user
	 */
	public function setUser(?User $user): void
	{
		$this->user = $user;
	}

	/**
	 * @return GameGroup|null
	 */
	public function getGameGroup(): ?GameGroup
	{
		return $this->gameGroup;
	}

	/**
	 * @param GameGroup|null $gameGroup
	 */
	public function setGameGroup(?GameGroup $gameGroup): void
	{
		$this->gameGroup = $gameGroup;
	}
}
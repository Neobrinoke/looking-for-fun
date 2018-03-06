<?php

namespace App\Entity;

use App\Framework\ORM\Entity;
use DateTime;

/**
 * @Table(name="game_accounts")
 */
class GameAccount extends Entity
{
	/**
	 * @var int
	 * @Column(name="id")
	 */
	private $id;

	/**
	 * @var User|null
	 * @Column(name="user_id")
	 */
	private $user;

	/**
	 * @var string
	 * @Column(name="player_name")
	 */
	private $playerName;

	/**
	 * @var string
	 * @Column(name="server_location")
	 */
	private $serverLocation;

	/**
	 * @var DateTime
	 * @Column(name="created_at")
	 */
	private $createdAt;

	/**
	 * @var DateTime
	 * @Column(name="updated_at")
	 */
	private $updatedAt;

	/**
	 * @var DateTime|null
	 * @Column(name="deleted_at")
	 */
	private $deletedAt;

	/**
	 * AccountGame constructor.
	 */
	public function __construct()
	{
		$this->setId(0);
		$this->setUser(null);
		$this->setPlayerName('');
		$this->setServerLocation('');
		$this->setCreatedAt(new DateTime());
		$this->setUpdatedAt(new DateTime());
		$this->setDeletedAt(null);
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
	 * @return string
	 */
	public function getPlayerName(): string
	{
		return $this->playerName;
	}

	/**
	 * @param string $playerName
	 */
	public function setPlayerName(string $playerName): void
	{
		$this->playerName = $playerName;
	}

	/**
	 * @return string
	 */
	public function getServerLocation(): string
	{
		return $this->serverLocation;
	}

	/**
	 * @param string $serverLocation
	 */
	public function setServerLocation(string $serverLocation): void
	{
		$this->serverLocation = $serverLocation;
	}

	/**
	 * @return DateTime
	 */
	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	/**
	 * @param DateTime $createdAt
	 */
	public function setCreatedAt(DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}

	/**
	 * @return DateTime
	 */
	public function getUpdatedAt(): DateTime
	{
		return $this->updatedAt;
	}

	/**
	 * @param DateTime $updatedAt
	 */
	public function setUpdatedAt(DateTime $updatedAt): void
	{
		$this->updatedAt = $updatedAt;
	}

	/**
	 * @return DateTime|null
	 */
	public function getDeletedAt(): ?DateTime
	{
		return $this->deletedAt;
	}

	/**
	 * @param DateTime|null $deletedAt
	 */
	public function setDeletedAt(?DateTime $deletedAt): void
	{
		$this->deletedAt = $deletedAt;
	}
}
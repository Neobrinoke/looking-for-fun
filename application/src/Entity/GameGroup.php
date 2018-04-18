<?php

namespace App\Entity;

use App\Framework\Database\Entity;
use DateTime;

/**
 * @Table(name="game_groups")
 */
class GameGroup extends Entity
{
	/**
	 * @var int
	 * @Column(name="id")
	 */
	private $id;

	/**
	 * @var string
	 * @Column(name="name")
	 */
	private $name;

	/**
	 * @var string
	 * @Column(name="description")
	 */
	private $description;

	/**
	 * @var User|null
	 * @Column(name="owner_id")
	 */
	private $owner;

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
	 * GroupGame constructor.
	 */
	public function __construct()
	{
		$this->setId(0);
		$this->setName('');
		$this->setDescription('');
		$this->setOwner(null);
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
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription(string $description): void
	{
		$this->description = $description;
	}

	/**
	 * @return User|null
	 */
	public function getOwner(): ?User
	{
		return $this->owner;
	}

	/**
	 * @param User|null $owner
	 */
	public function setOwner(?User $owner): void
	{
		$this->owner = $owner;
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
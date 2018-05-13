<?php

namespace App\Model;

use App\Framework\Database\Model;

class GameGroup extends Model
{
	const TABLE = 'game_groups';

	/** @var int */
	public $id;
	/** @var string */
	public $name;
	/** @var string */
	public $description;
	/** @var int */
	public $owner_id;
	/** @var string */
	public $created_at;
	/** @var string */
	public $updated_at;
	/** @var string */
	public $deleted_at;

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
	 * @return int
	 */
	public function getOwnerId(): int
	{
		return $this->owner_id;
	}

	/**
	 * @param int $owner_id
	 */
	public function setOwnerId(int $owner_id): void
	{
		$this->owner_id = $owner_id;
	}

	/**
	 * @return string
	 */
	public function getCreatedAt(): string
	{
		return $this->created_at;
	}

	/**
	 * @param string $created_at
	 */
	public function setCreatedAt(string $created_at): void
	{
		$this->created_at = $created_at;
	}

	/**
	 * @return string
	 */
	public function getUpdatedAt(): string
	{
		return $this->updated_at;
	}

	/**
	 * @param string $updated_at
	 */
	public function setUpdatedAt(string $updated_at): void
	{
		$this->updated_at = $updated_at;
	}

	/**
	 * @return string
	 */
	public function getDeletedAt(): string
	{
		return $this->deleted_at;
	}

	/**
	 * @param string $deleted_at
	 */
	public function setDeletedAt(string $deleted_at): void
	{
		$this->deleted_at = $deleted_at;
	}

	/**
	 * @return User|null
	 * @throws \Exception
	 */
	public function getOwner(): ?User
	{
		return $this->hasOne(User::class, 'owner_id', 'id');
	}
}
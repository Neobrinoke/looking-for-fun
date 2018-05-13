<?php

namespace App\Model;

use App\Framework\Database\Model;
use App\Framework\Support\Collection;

class User extends Model
{
	const TABLE = 'users';

	/** @var int */
	public $id;
	/** @var string */
	public $name;
	/** @var string */
	public $login;
	/** @var string */
	public $password;
	/** @var string */
	public $email;
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
	public function getLogin(): string
	{
		return $this->login;
	}

	/**
	 * @param string $login
	 */
	public function setLogin(string $login): void
	{
		$this->login = $login;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email): void
	{
		$this->email = $email;
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
	 * @return Collection
	 * @throws \Exception
	 */
	public function getGameGroups()
	{
		return $this->hasMany(GameGroup::class, 'id', 'owner_id');
	}
}
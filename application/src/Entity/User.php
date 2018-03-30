<?php

namespace App\Entity;

use App\Framework\Database\Entity;
use DateTime;

/**
 * @Table(name="users")
 */
class User extends Entity
{
	public const SAFE_DELETE = true;

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
	 * @Column(name="login")
	 */
	private $login;

	/**
	 * @var string
	 * @Column(name="password")
	 */
	private $password;

	/**
	 * @var string
	 * @Column(name="email")
	 */
	private $email;

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
	 * User constructor.
	 */
	public function __construct()
	{
		$this->setId(0);
		$this->setName('');
		$this->setLogin('');
		$this->setPassword('');
		$this->setEmail('');
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
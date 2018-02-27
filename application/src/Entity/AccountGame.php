<?php

namespace App\Entity;

use DateTime;

class AccountGame extends Entity
{
    /** @var int */
    private $id;

    /** @var User|null */
    private $user;

    /** @var string */
    private $playerName;

    /** @var string */
    private $serverLocation;

    /** @var DateTime */
    private $createdAt;

    /** @var DateTime */
    private $updatedAt;

    /** @var DateTime|null */
    private $deletedAt;

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

    /**
     * AccountGame constructor.
     */
    public function __construct()
    {
        $this->setUser(null);
        $this->setPlayerName('');
        $this->setServerLocation('');
        $this->setCreatedAt(new DateTime());
        $this->setUpdatedAt(new DateTime());
        $this->setDeletedAt(null);
    }
}
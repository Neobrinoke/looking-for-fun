<?php

namespace App\Entity;

class GameGroupUser extends Entity
{
    /** @var int */
    private $id;

    /** @var User|null */
    private $user;

    /** @var GroupGame|null */
    private $groupGame;

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
     * @return GroupGame|null
     */
    public function getGroupGame(): ?GroupGame
    {
        return $this->groupGame;
    }

    /**
     * @param GroupGame|null $groupGame
     */
    public function setGroupGame(?GroupGame $groupGame): void
    {
        $this->groupGame = $groupGame;
    }

    /**
     * GameGroupUser constructor.
     */
    public function __construct()
    {
        $this->setUser(null);
        $this->setGroupGame(null);
    }
}
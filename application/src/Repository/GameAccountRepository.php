<?php

namespace App\Repository;

use App\Entity\GameAccount;

class GameAccountRepository extends Repository
{
    /**
     * Persist entity
     *
     * @param GameAccount $gameAccount
     * @return bool
     */
    public function persist(GameAccount $gameAccount): bool
    {
        if ($gameAccount->getId() == 0) {
            return $this->insert($gameAccount);
        } else {
            return $this->update($gameAccount);
        }
    }

    /**
     * Find one entity with options
     *
     * @param int $id
     * @return GameAccount
     * @throws \Exception
     */
    public function findById(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM game_accounts WHERE id = ?');
        $statement->execute([$id]);

        $result = $statement->fetchObject();
        if (!$result) {
            throw new \Exception('Invalid entity');
        }

        return $this->convertToEntity($result);
    }

    /**
     * Insert entity in db
     *
     * @param GameAccount $gameAccount
     * @return bool
     */
    private function insert(GameAccount $gameAccount): bool
    {
        $pdo_statement = $this->pdo->prepare('INSERT INTO game_accounts (user_id, player_name, server_location, created_at, updated_at, deleted_at) VALUES (?, ?, ?, ?, ?, ?)');

        return $pdo_statement->execute([
            $gameAccount->getUser()->getId(),
            $gameAccount->getPlayerName(),
            $gameAccount->getServerLocation(),
            $gameAccount->getCreatedAt()->format('Y:m:d H:i:s'),
            $gameAccount->getUpdatedAt()->format('Y:m:d H:i:s'),
            null
        ]);
    }

    /**
     * Update entity in db
     *
     * @param GameAccount $gameAccount
     * @return bool
     */
    private function update(GameAccount $gameAccount): bool
    {
        $pdo_statement = $this->pdo->prepare('UPDATE game_accounts SET user_id = ?, player_name = ?, server_location = ?, created_at = ?, updated_at = ?, deleted_at = ? WHERE id = ?');

        return $pdo_statement->execute([
            $gameAccount->getUser()->getId(),
            $gameAccount->getPlayerName(),
            $gameAccount->getServerLocation(),
            $gameAccount->getCreatedAt()->format('Y:m:d H:i:s'),
            $gameAccount->getUpdatedAt()->format('Y:m:d H:i:s'),
            $gameAccount->getId()
        ]);
    }

    /**
     * Convert db result to entity
     *
     * @param \stdClass $result
     * @return GameAccount
     * @throws \Exception
     */
    private function convertToEntity(\stdClass $result): GameAccount
    {
        $userRepository = new UserRepository();
        $user = $userRepository->findById($result->user_id);

        $gameAccount = new GameAccount();
        $gameAccount->setId($result->id);
        $gameAccount->setUser($user);
        $gameAccount->setPlayerName($result->player_name);
        $gameAccount->setServerLocation($result->server_location);
        $gameAccount->setCreatedAt(new \DateTime($result->created_at));
        $gameAccount->setUpdatedAt(new \DateTime($result->updated_at));
        $gameAccount->setDeletedAt(is_null($result->deleted_at) ? $result->deleted_at : new \DateTime($result->deleted_at));

        return $gameAccount;
    }
}
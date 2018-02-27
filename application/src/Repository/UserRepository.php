<?php

namespace App\Repository;

use App\Entity\User;

class UserRepository extends Repository
{
    /**
     * Persist entity
     *
     * @param User $user
     * @return bool
     */
    public function persist(User $user): bool
    {
        if ($user->getId() == 0) {
            return $this->insert($user);
        } else {
            return $this->update($user);
        }
    }

    /**
     * Find one entity with options
     *
     * @param int $id
     * @return User
     * @throws \Exception
     */
    public function findById(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
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
     * @param User $user
     * @return bool
     */
    private function insert(User $user): bool
    {
        $pdo_statement = $this->pdo->prepare('INSERT INTO users (name, login, password, email, created_at, updated_at, deleted_at) VALUES (?, ?, ?, ?, ?, ?, ?)');

        return $pdo_statement->execute([
            $user->getName(),
            $user->getLogin(),
            $user->getPassword(),
            $user->getEmail(),
            $user->getCreatedAt()->format('Y:m:d H:i:s'),
            $user->getUpdatedAt()->format('Y:m:d H:i:s'),
            null
        ]);
    }

    /**
     * Update entity in db
     *
     * @param User $user
     * @return bool
     */
    private function update(User $user): bool
    {
        $pdo_statement = $this->pdo->prepare('UPDATE users SET name = ?, login = ?, password = ?, email = ?, created_at = ?, updated_at = ?, deleted_at = ? WHERE id = ?');

        return $pdo_statement->execute([
            $user->getName(),
            $user->getLogin(),
            $user->getPassword(),
            $user->getEmail(),
            $user->getCreatedAt()->format('Y:m:d H:i:s'),
            $user->getUpdatedAt()->format('Y:m:d H:i:s'),
            $user->getDeletedAt() ? $user->getDeletedAt()->format('Y:m:d H:i:s') : null,
            $user->getId()
        ]);
    }

    /**
     * Convert db result to entity
     *
     * @param \stdClass $result
     * @return User
     */
    private function convertToEntity(\stdClass $result): User
    {
        $user = new User();
        $user->setId($result->id);
        $user->setName($result->name);
        $user->setLogin($result->login);
        $user->setPassword($result->password);
        $user->setEmail($result->email);
        $user->setCreatedAt(new \DateTime($result->created_at));
        $user->setUpdatedAt(new \DateTime($result->updated_at));
        $user->setDeletedAt(is_null($result->deleted_at) ? $result->deleted_at : new \DateTime($result->deleted_at));

        return $user;
    }
}
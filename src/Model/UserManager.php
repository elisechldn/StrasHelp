<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';
    public array $credentials;

    /**
     * Insert new user in database
     */
    public function insert(array $credentials): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(firstname, lastname,
         username, password, email, phone_number, birthdate, localisation) 
         VALUES (:firstname, :lastname, :username, :password, :email, :phone_number, :birthdate, :localisation)");
        $statement->bindValue(':firstname', $credentials['firstname']);
        $statement->bindValue(':lastname', $credentials['lastname']);
        $statement->bindValue(':username', $credentials['username']);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
        $statement->bindValue(':email', $credentials['email']);
        $statement->bindValue(':phone_number', $credentials['phone_number']);
        $statement->bindValue(':birthdate', $credentials['birthdate']);
        $statement->bindValue(':localisation', $credentials['localisation']);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update item in database
     */
    public function updateUsers(array $updateFields): bool
    {

        $statement = $this->pdo->prepare(" UPDATE " . self::TABLE . " SET firstname = :firstname, 
        birthdate = :birthdate,
        lastname = :lastname, email = :email, phone_number = :phone_number,
         username = :username, localisation = :localisation,
        password = :password WHERE id=:id ");
        $statement->bindValue(':firstname', $updateFields['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $updateFields['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $updateFields['email']);
        $statement->bindValue(':phone_number', $updateFields['phone_number']);
        $statement->bindValue(':birthdate', $updateFields['birthdate']);
        $statement->bindValue(':username', $updateFields['username']);
        $statement->bindValue(':localisation', $updateFields['localisation']);
        $statement->bindValue(':id', $updateFields['id']);
        $statement->bindValue(':password', password_hash($updateFields['password'], PASSWORD_DEFAULT));

        return $statement->execute();
    }

    public function selectOneByIdentifiant($identifiant): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM "
         . static::TABLE . " WHERE username=:identifiant OR email =:identifiant");
        $statement->bindValue(':identifiant', $identifiant);
        $statement->execute();

        return $statement->fetch();
    }
    public function deleteUser(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE user.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function selectAllUsers(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }
}

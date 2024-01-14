<?php

namespace App\Model;

class ContactManager extends AbstractManager
{
    public const TABLE = 'contact';
    public array $credentialsContact;

    public function insert(array $credentialsContact, $userId): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (firstname, 
        lastname, email, message, user_id) VALUES (:firstname, 
        :lastname, :email, :message, NULL)");
        $statement->bindValue(':firstname', $credentialsContact['firstname']);
        $statement->bindValue(':lastname', $credentialsContact['lastname']);
        $statement->bindValue(':email', $credentialsContact['email']);
        $statement->bindValue(':message', $credentialsContact['message']);
        $statement->bindValue(':message', $userId);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}

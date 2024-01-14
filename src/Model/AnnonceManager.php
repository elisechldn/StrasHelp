<?php

namespace App\Model;

class AnnonceManager extends AbstractManager
{
    public const TABLE = 'ad';
    public const JOINTURE = 'reponse';

    // Fonction pour les cards des annonces avec un affichage par 3
    public function selectAllAd(string $orderBy = 'ad.id', string $direction = 'DESC'): array
    {
        $query = 'SELECT ad.id, title, image, description, published_date, user.username, 
        user.localisation, category.name, ad_type.nametype FROM ' . static::TABLE .
        ' JOIN category ON ad.category_id = category.id JOIN ad_type ON ad.ad_type_id = ad_type.id 
        JOIN user ON ad.user_id = user.id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction . ' LIMIT 3';
        }
        return $this->pdo->query($query)->fetchAll();
    }

    public function selectByPage($page = 0, $category = 0, $type = 0)
    {
        $where = '';
        $whereCat = '';
        $whereType = '';

        if ($category) {
            $whereCat = ' category.id = :category ';
        }

        if ($type) {
            $whereType = ' ad_type.id = :type ';
        }

        if ($category || $type) {
            $where = ' WHERE ';
            if ($category) {
                $where .= $whereCat;
            }
            if ($type) {
                $where .= $whereType;
            }
        }

        if ($category && $type) {
            $where = ' WHERE ';
            $where .= $whereCat . ' AND ' . $whereType;
        }

        $statement = $this->pdo->prepare('SELECT ad.id, title, image, description, 
        published_date, user.username, user.localisation, category.name, ad_type.nametype 
        FROM ' . static::TABLE . ' JOIN category ON ad.category_id = category.id 
        JOIN ad_type ON ad.ad_type_id = ad_type.id 
        JOIN user ON ad.user_id = user.id ' . $where .
        ' ORDER BY ad.id DESC LIMIT :page, 3 ');

        if ($category || $type) {
            if ($category) {
                $statement->bindValue(':category', $category, \PDO::PARAM_INT);
            }
            if ($type) {
                $statement->bindValue(':type', $type, \PDO::PARAM_INT);
            }
        }

        $statement->bindValue(':page', ($page * 3), \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function countAnnonce()
    {
        $query = ('SELECT count(`id`) as countads FROM ' . static::TABLE);

        return $this->pdo->query($query)->fetchAll();
    }

    public function createAnnonce(array $ads, $userId)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (title, description, image,
         published_date, user_id, category_id, ad_type_id) VALUES (:title, 
        :description, :image, NOW(), :user_id, :category_id, :ad_type_id)");
        $statement->bindValue(':title', $ads['title'], \PDO::PARAM_STR);
        $statement->bindValue(':image', $ads['image'], \PDO::PARAM_STR);
        $statement->bindValue(':description', $ads['description'], \PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':category_id', $ads['category'], \PDO::PARAM_INT);
        $statement->bindValue(':ad_type_id', $ads['radio'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function category()
    {
        $query = ("SELECT * FROM category");

        return $this->pdo->query($query)->fetchAll();
    }

    public function adType()
    {
        $query = ("SELECT * FROM ad_type");

        return $this->pdo->query($query)->fetchAll();
    }

    public function selectOneByIdAd(int $id): array|false
    {
        $statement = $this->pdo->prepare("SELECT ad.id, title, image, description, published_date,
        user.username, user.localisation, category.name, ad_type.nametype FROM " . static::TABLE .
        " JOIN category ON ad.category_id = category.id INNER JOIN ad_type ON ad.ad_type_id = ad_type.id 
        JOIN user ON ad.user_id = user.id WHERE ad.id=:id ");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function responseAd(array $response, $userUserName, $userMail)
    {
        $statement = $this->pdo->prepare('INSERT INTO ' . static::JOINTURE . ' (name, mail,
         description) VALUES (:name, :mail, :description)');
        $statement->bindValue(':name', $userUserName);
        $statement->bindValue(':mail', $userMail);
        $statement->bindValue(':description', $response['user_description']);
    }

    public function selectAd(): array
    {
        $query = ('SELECT ad.id, title, image, description, 
        published_date, user.username, user.localisation, category.name, 
        ad_type.nametype FROM ' . static::TABLE . ' JOIN category 
        ON ad.category_id = category.id JOIN ad_type ON ad.ad_type_id = ad_type.id 
        JOIN user ON ad.user_id = user.id ');

        return $this->pdo->query($query)->fetchAll();
    }

    public function deleteAd(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}

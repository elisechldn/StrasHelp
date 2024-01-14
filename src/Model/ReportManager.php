<?php

namespace App\Model;

class ReportManager extends AbstractManager
{
    public const TABLE = 'report_ad';
    public const JOINTURE = 'signal_report';

    public function selectReports(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }

    public function insertReports(array $reportAd)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`report_reason`) VALUES (:report_reason)");
        $statement->bindValue(':report_reason', $reportAd['report_reason'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}

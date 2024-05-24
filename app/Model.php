<?php

namespace Book\Shop;

use PDO;
use PDOStatement;
use Book\Shop\Helpers\Database;

abstract class Model
{
    private Database $database;
    protected string $table;
    protected string $primaryColumn = "id";

    public function __construct()
    {
        try {
            $this->database = Database::getInstance();
        }catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function insert(array $colomns, array $values): int
    {
        $prepareColumns = array_map(function () {
            return "?";
        }, $colomns);

        $sql = "INSERT INTO $this->table (" . implode(",", $colomns) . ") VALUES (" . implode(",", $prepareColumns) . ")";
        $this->database->getConnection()->prepare($sql)->execute($values);
        return $this->database->getConnection()->lastInsertId();
    }

    public function getById(int $id): ?array
    {
        $sql = "select * from $this->table where $this->primaryColumn = " . $id . " limit 1";
        $statement = $this->database->getConnection()->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function all(): void
    {
        //
    }
}

<?php

namespace Book\Shop;

use PDO;
use PDOStatement;
use Book\Shop\Helpers\Database;

abstract class Model
{
    private Database $database;
    protected $table;
    protected string $primaryColumn = "id";
    private PDOStatement $statement;
    private string $columns = "*";

    /**
     * Constructs a new Model instance.
     */
    public function __construct()
    {
        try {
            $this->database = Database::getInstance();
        }catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Specifies a relationship with another model using a single join.
     *
     */
    public function with(string $class, string $key): self
    {
        $class = "Book\\Shop\\Models\\$class";
        $model = new $class;
        $sql = "select $this->columns from $this->table INNER JOIN $model->table ON " . $model->table . "." . $model->primaryColumn . " = $this->table.$key";
        $this->statement = $this->database->getConnection()->query($sql);
        return $this;
    }

     /**
     * Specifies relationships with multiple models using multiple joins.
     *
     */
    public function withMulti(array $classes): self
    {
        $joins = [];
        foreach ($classes as $key => $class) {
            $class = "Book\\Shop\\Models\\$class";
            $model = new $class;
            $joins[] = " INNER JOIN $model->table ON " . $model->table . "." . $model->primaryColumn . " = $this->table.$key";
        }

        $sql = "select $this->columns from $this->table" . implode(" ", $joins);
        $this->statement = $this->database->getConnection()->query($sql);
        return $this;
    }

    /**
     * Executes the query and retrieves the result set.
     *
     */
    public function get(): array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Specifies the columns to select in the query.
     *
     */
    public function as(string $column): self
    {
        $this->columns = $column;
        return $this;
    }

     /**
     * Inserts a new record into the database table.
     *
     */
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

     /**
     * Retrieves all records from the database table.
     * 
     */
    public function all(): ?array
    {
        $sql = "select * from $this->table";
        $statement = $this->database->getConnection()->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php

namespace Book\Shop\Helpers;

use PDO;
use Exception;

class Database
{
    private static $instance;
    private $connection;

    public function __construct()
    {
        if (empty(self::$instance)) {
            try {
                $this->connection = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\Exception $error) {
                throw new Exception("Connection failed : " . $error->getMessage());
            }
        }
    }

    /**
     * Retrieves the singleton instance of the Database class.
     *
     * @return Database The singleton instance.
     */
    public static function getInstance(): Database
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Retrieves the PDO database connection object.
     *
     * @return PDO The PDO database connection object.
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}

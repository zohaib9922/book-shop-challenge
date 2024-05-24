<?php

namespace Book\Shop\Helpers;

use PDO;

class Migration
{
    protected PDO $database;

    public function __construct()
    {
        $this->database = Database::getInstance()->getConnection();
    }

    public function apply($sql): void
    {
        $this->database->exec($sql);
    }
}

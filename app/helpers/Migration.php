<?php

namespace Book\Shop\Helpers;

class Migration
{
    protected $database;

    public function __construct()
    {
        $this->database = Database::getInstance()->getConnection();
    }

    public function apply($sql): void
    {
        $this->database->exec($sql);
    }
}

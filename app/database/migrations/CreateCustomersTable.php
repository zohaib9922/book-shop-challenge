<?php

namespace Book\Shop\Database\Migrations;

use Book\Shop\Helpers\Migration;

class CreateCustomersTable extends Migration
{
    public function up(): void
    {
        $sql = "
            CREATE TABLE customers (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name varchar(255) NOT NULL,
                email varchar(255) NOT NULL,
                created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";
        $this->apply($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS customers;";
        $this->apply($sql);
    }
}

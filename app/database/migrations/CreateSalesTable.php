<?php

namespace Book\Shop\Database\Migrations;

use Book\Shop\Helpers\Migration;

class CreateSalesTable extends Migration
{
    public function up(): void
    {
        $sql = "
            CREATE TABLE sales (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                customer_id int(11) NOT NULL,
                product_id int(11) NOT NULL,
                sale_date varchar(255) NOT NULL,
                version varchar(255) NOT NULL,
                created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";
        $this->apply($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS sales;";
        $this->apply($sql);
    }
}

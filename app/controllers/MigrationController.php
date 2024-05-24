<?php

namespace Book\Shop\Controllers;

use Book\Shop\Controller;

class MigrationController extends Controller
{
    public function up(): void
    {
        $classes = $this->getAll();
        foreach ($classes as $class) {
            $migration = new $class;
            $migration->up();
            echo "Migration run successfully: $class<br>";
        }
    }

    public function down(): void
    {
        $classes = $this->getAll();
        foreach ($classes as $class) {
            $migration = new $class;
            $migration->down();
            echo "Migration run successfully: $class<br>";
        }
    }

    private function getAll(): array
    {
        // getting all migrations classes to run migrations
        $files = scandir(__DIR__ . '/../database/migrations');
        $classes = [];
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            $file = explode(".", $file)[0];
            $classes[] = "Book\\Shop\\Database\\Migrations\\$file";
        }

        return $classes;
    }
}

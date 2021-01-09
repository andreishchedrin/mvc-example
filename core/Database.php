<?php

namespace app\core;

use app\core\Application;

/**
 * Class Database
 *
 * @package app\core
 */

class Database
{
    public \PDO $pdo;

    public function __construct(array $configDb)
    {
        $this->pdo = new \PDO($configDb['dsn'], $configDb['user'], $configDb['password']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigration()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $newMigrations = [];

        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $files = array_diff($files, array('..', '.'));

        $toApply = array_diff($files, $appliedMigrations);

        foreach ($toApply as $item) {
            require_once Application::$ROOT_DIR . '/migrations/' . $item;
            $className = pathinfo($item, PATHINFO_FILENAME);
            $instance = new $className();
            echo "Applying migration {$item} ..." . PHP_EOL;
            $instance->up();
            $newMigrations[] = $item;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        }
        echo "Done." . PHP_EOL;
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;"
        );
    }

    public function getAppliedMigrations()
    {
        $stmt = $this->pdo->prepare("SELECT migration FROM migrations");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $migrations = implode(",", array_map(fn($m) => "('{$m}')", $migrations));
        $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES {$migrations}");
        $stmt->execute();
    }

    public function save(ActiveRecord $activeRecord)
    {
        $tableName = $activeRecord->tableName();
        $attributes = $activeRecord->attributes();
        $params = array_map(fn($attr) => ":{$attr}", $attributes);
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$tableName} (" . implode(',', $attributes) . ")
            VALUES (" . implode(',', $params) . ")"
        );
        foreach ($attributes as $attribute) {
            $stmt->bindValue(":{$attribute}", $activeRecord->{$attribute});
        }
        $stmt->execute();
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Settings\SettingsInterface;
use PDO;
use PDOStatement;

abstract class PostgresRepository
{
    protected PDO $pdo;

    public function __construct(SettingsInterface $settings)
    {
        $db = $settings->get()['db'];

        $dsn = $this->constructDSN($db['name'], $db['host'], (int) $db['port']);

        $this->pdo = new PDO($dsn, $db['user'], $db['password']);
    }

    protected function query(string $query, array $params = []): PDOStatement
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        return $statement;
    }

    private function constructDSN(string $dbname, string $host, int $port): string
    {
        return "pgsql:dbname=$dbname;host=$host;port=$port";
    }
}
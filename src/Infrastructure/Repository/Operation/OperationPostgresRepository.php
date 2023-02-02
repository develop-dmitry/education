<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Operation;

use App\Domain\Operation\Operation;
use App\Domain\Operation\OperationNotFoundException;
use App\Domain\Operation\OperationNotSavedException;
use App\Domain\Operation\OperationRepository;
use App\Infrastructure\Repository\PostgresRepository;
use PDO;
use PDOException;

class OperationPostgresRepository extends PostgresRepository implements OperationRepository
{
    protected string $table = 'operations';

    protected string $primaryKey = 'id';

    public function findAll(): array
    {
        $statement = $this->query("SELECT * FROM {$this->table}");

        $result = [];

        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $operation) {
            $result[] = $this->makeOperation($operation);
        }

        return $result;
    }

    public function find(int $id): Operation
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :primaryKey";

        $statement = $this->query($query, ['primaryKey' => $id]);

        $operation = $statement->fetch();

        if (empty($operation)) {
            throw new OperationNotFoundException("Operation with {$this->primaryKey}=$id not found");
        }

        return $this->makeOperation($operation);
    }

    public function save(Operation $operation): void
    {
        try {
            if ($this->exists($operation)) {
                $this->update($operation);
            } else {
                $this->insert($operation);
            }
        } catch (PDOException) {
            throw new OperationNotSavedException('Operation could not be saved');
        }
    }

    protected function makeOperation(array $params): Operation
    {
        return Operation::fromArray($params);
    }

    private function insert(Operation $operation): void
    {
        $params = $operation->toArray();

        if (is_null($operation->getId())) {
            unset($this->primaryKey);
        }

        $values = implode(',', array_map(static fn ($item) => ":$item", array_keys($params)));
        $keys = implode(',', array_keys($params));

        $query = "INSERT INTO {$this->table} ($keys) VALUES ($values) RETURNING id";

        $statement = $this->query($query, $params);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $operation->setId($result['id']);
    }

    private function update(Operation $operation): void
    {
        $params = $operation->toArray();

        unset($params['id']);

        $query = "UPDATE {$this->table} SET ";

        foreach ($params as $key => $value) {
            $query .= " $key = :$key";

            if (array_key_last($params) !== $key) {
                $query .= ',';
            }
        }

        $query .= " WHERE {$this->primaryKey} = :{$this->primaryKey}";

        $params[$this->primaryKey] = $operation->getId();

        $this->query($query, $params);
    }

    private function exists(Operation $operation): bool
    {
        $query = "SELECT EXISTS
            (SELECT {$this->primaryKey} FROM {$this->table} WHERE {$this->primaryKey} = :{$this->primaryKey})";

        $statement = $this->query($query, [$this->primaryKey => $operation->getId()]);

        $exists = $statement->fetch(PDO::FETCH_ASSOC);

        return $exists['exists'];
    }
}
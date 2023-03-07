<?php

declare(strict_types=1);

namespace App\Domain\Operation;

interface OperationRepository
{
    /**
     * @return Operation[]
     */
    public function findAll(): array;

    /**
     * @throws OperationNotFoundException
     */
    public function find(int $id): Operation;

    /**
     * @throws OperationNotSavedException
     */
    public function save(Operation $operation): void;

    /**
     * @throws OperationNotDeletedException
     */
    public function delete(int $id): void;
}

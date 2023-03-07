<?php

declare(strict_types=1);

namespace App\Domain\Operation;

use App\Domain\Operation\DTO\GetOperationRequest;

interface OperationRepository
{
    /**
     * @return Operation[]
     */
    public function findAll(GetOperationRequest $request): array;

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

    public function getElementCount(): int;
}

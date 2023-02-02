<?php

declare(strict_types=1);

namespace App\Domain\Operation;

use App\Application\Exception\FileNotFoundException;

interface OperationBackup
{
    public function dump(string $path): void;

    /**
     * @throws FileNotFoundException
     * @throws OperationNotFoundException
     * @throws OperationNotSavedException
     */
    public function import(string $path): void;
}
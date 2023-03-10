<?php

declare(strict_types=1);

use App\Domain\Operation\OperationRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Repository\Operation\OperationPostgresRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        OperationRepository::class => \DI\autowire(OperationPostgresRepository::class)
    ]);
};

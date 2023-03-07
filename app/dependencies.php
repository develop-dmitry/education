<?php

declare(strict_types=1);

use App\Application\Backup\OperationBackupUseCase;
use App\Application\Settings\SettingsInterface;
use App\Domain\Operation\OperationBackup;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

return static function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        OperationBackup::class => DI\autowire(OperationBackupUseCase::class),

        PhpRenderer::class => fn (): PhpRenderer => new PhpRenderer('../resources/views/')
    ]);
};

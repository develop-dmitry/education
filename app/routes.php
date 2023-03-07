<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Infrastructure\Http\HomeController;
use App\Infrastructure\Http\OperationController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return static function (App $app) {
    $app->group('/api', function (Group $version) {
        $version->group('/v1', function (Group $entity) {
            $entity->group('/operation', function (Group $operation) {
                $operation->post('/create', [OperationController::class, 'createOperation']);
                $operation->post('/list', [OperationController::class, 'getOperations']);
                $operation->post('/delete', [OperationController::class, 'deleteOperation']);
                $operation->post('/count', [OperationController::class, 'getOperationCount']);
            });
        });
    });

    $app->get('/{routes:.*}', [HomeController::class, 'index']);
};

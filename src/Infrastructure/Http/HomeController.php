<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Operation\OperationBackup;
use App\Domain\Operation\OperationRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    public function __construct(
        private readonly OperationRepository $operationRepository,
        private readonly OperationBackup $operationDump
    ) {
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->operationDump->import($_SERVER['DOCUMENT_ROOT'] . '/storage/operations.xml');

        return $response;
    }
}
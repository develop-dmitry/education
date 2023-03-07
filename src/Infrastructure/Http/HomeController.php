<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Operation\OperationBackup;
use App\Domain\Operation\OperationRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class HomeController
{
    public function __construct(
        private readonly PhpRenderer $renderer
    ) {
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->renderer->render($response, 'index.php');
    }
}
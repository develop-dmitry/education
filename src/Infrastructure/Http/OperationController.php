<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\Validator\RegExp;
use App\Application\Validator\Validator;
use App\Application\Validator\ValidatorItem;
use App\Domain\Operation\Operation;
use App\Domain\Operation\OperationNotDeletedException;
use App\Domain\Operation\OperationRepository;
use DateTime;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;

class OperationController
{
    public function __construct(
        private readonly OperationRepository $operationRepository
    ) {
    }

    public function createOperation(Request $request, ResponseInterface $response): ResponseInterface
    {
        $rules = [
            'amount' => fn ($value): bool => is_numeric($value),
            'date' => fn ($value): bool => is_string($value)
        ];
        $data = $request->getParsedBody();
        $validator = new Validator($rules, $data);

        if (!$validator->validate()) {
            $result = ['success' => false];
            $response = $response->withStatus(400);
        } else {
            try {
                $operation = (Operation::make())
                    ->setAmount((float) $data['amount'])
                    ->setTransactionDate(new DateTime($data['date']));

                $this->operationRepository->save($operation);

                $result = ['success' => true];
            } catch (Exception) {
                $result = ['success' => false];
                $response = $response->withStatus(500);
            }
        }

        $response->getBody()->write(json_encode($result));

        return $response;
    }

    public function getOperations(Request $request, ResponseInterface $response): ResponseInterface
    {
        $result = [];
        $operations = $this->operationRepository->findAll();

        foreach ($operations as $operation) {
            $result[] = $operation->toArray();
        }


        $response->getBody()->write(json_encode(['success' => true, 'items' => $result]));

        return $response;
    }

    public function deleteOperation(Request $request, ResponseInterface $response): ResponseInterface
    {
        $rules = ['id' => new RegExp("/^\d+$/")];
        $data = $request->getParsedBody();
        $validator = new Validator($rules, $data);

        if ($validator->validate()) {
            try {
                $this->operationRepository->delete((int) $data['id']);

                $result = ['success' => true];
            } catch (OperationNotDeletedException) {
                $result = ['success' => false];
                $response = $response->withStatus(500);
            }
        } else {
            $result = ['success' => false];
            $response = $response->withStatus(400);
        }

        $response->getBody()->write(json_encode($result));

        return $response;
    }
}
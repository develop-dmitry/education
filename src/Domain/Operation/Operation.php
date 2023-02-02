<?php

declare(strict_types=1);

namespace App\Domain\Operation;

use App\Domain\Entity;
use DateTime;

class Operation extends Entity
{
    private function __construct(
        private ?int $id,
        private float $amount,
        private DateTime $transactionDate
    ) {
    }

    public static function make(): Operation
    {
        return new Operation(null, 0, new DateTime());
    }

    public static function fromArray(array $params): self
    {
        return new self(
            (int) $params['id'],
            (float) $params['amount'],
            new DateTime($params['transaction_date'])
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'amount' => $this->getAmount(),
            'transaction_date' => $this->getTransactionDate()->format('Y-m-d')
        ];
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param DateTime $transactionDate
     */
    public function setTransactionDate(DateTime $transactionDate): void
    {
        $this->transactionDate = $transactionDate;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return DateTime
     */
    public function getTransactionDate(): DateTime
    {
        return $this->transactionDate;
    }
}

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
        $id = (isset($params['id'])) ? (int) $params['id'] : null;

        return new self(
            $id,
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
     * @return Operation
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param float $amount
     * @return Operation
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param DateTime $transactionDate
     * @return Operation
     */
    public function setTransactionDate(DateTime $transactionDate): self
    {
        $this->transactionDate = $transactionDate;
        return $this;
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

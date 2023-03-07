<?php

declare(strict_types=1);

namespace App\Domain\Operation\DTO;

class GetOperationRequest
{
    public function __construct(
        private readonly int $limit,
        private readonly int $page
    ) {
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->limit * $this->page - $this->limit;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain;

abstract class Entity
{
    abstract public function toArray(): array;

    abstract public static function fromArray(array $params): self;
}
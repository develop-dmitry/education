<?php

declare(strict_types=1);

namespace App\Application\Validator;

class RegExp
{
    public function __construct(
        private readonly string $pattern
    ) {
    }

    public function match(string $value): bool
    {
        return (bool) preg_match($this->pattern, $value);
    }
}
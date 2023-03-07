<?php

declare(strict_types=1);

namespace App\Application\Validator;

use Closure;

class Validator
{
    private array $errors = [];

    public function __construct(
        private readonly array $rules,
        private readonly array $values
    ) {
    }

    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->rules as $key => $rule) {
            if (!isset($this->values[$key])) {
                $this->errors[] = $key;
                continue;
            }

            $value = $this->values[$key];

            if (!$this->validateItem($key, $value)) {
                $this->errors[] = $key;
            }
        }

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    private function validateItem(string $name, mixed $value): bool
    {
        if (!isset($this->rules[$name])) {
            return true;
        }

        $rule = $this->rules[$name];

        if ($rule instanceof Closure) {
            return $rule($value);
        }

        if ($rule instanceof RegExp) {
            return $rule->match((string) $value);
        }

        return false;
    }
}

<?php

namespace kikimarik\validation\error;

use kikimarik\validation\contract\ValidationError;

final class MultipleValidationError implements ValidationError
{
    /**
     * @var array<string>
     */
    private array $errors;

    /**
     * @param array<string> $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function read(): string
    {
        return implode("; ", $this->errors);
    }
}
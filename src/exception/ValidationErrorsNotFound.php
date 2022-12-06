<?php

namespace kikimarik\validation\exception;

use kikimarik\validation\contract\ValidationRuntimeException;
use RuntimeException;

final class ValidationErrorsNotFound extends RuntimeException implements ValidationRuntimeException
{
    public function __construct(string $rule)
    {
        parent::__construct("Not enough validation errors for rule $rule.");
    }
}

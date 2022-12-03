<?php

namespace kikimarik\validation\contract;

interface ValidationRequest
{
    /**
     * @throws ValidationRuntimeException
     */
    public function add(string $field, ValidationRule $rule): self;

    /**
     * @param array<string,mixed> $payload
     */
    public function validate(array $payload): ValidationReport;
}

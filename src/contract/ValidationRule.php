<?php

namespace kikimarik\validation\contract;

interface ValidationRule
{
    /**
     * @param mixed $value
     * @throws ValidationRuntimeException
     */
    public function check($value): bool;

    /**
     * @throws ValidationRuntimeException
     */
    public function fail(): ValidationError;
}

<?php

namespace kikimarik\validation\report;

use JsonSerializable;
use kikimarik\validation\contract\ValidationError;
use kikimarik\validation\contract\ValidationReport;

final class JsonValidationReport implements ValidationReport, JsonSerializable
{
    /** @var array<string,ValidationError> */
    private array $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    public function add(string $field, ValidationError $error): ValidationReport
    {
        $this->errors[$field] = $error;
        return $this;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $errors = [];
        foreach ($this->errors as $field => $error) {
            $errors[$field] = $error->read();
        }
        return [
            "errors" => $errors
        ];
    }
}

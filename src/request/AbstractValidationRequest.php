<?php

namespace kikimarik\validation\request;

use kikimarik\validation\contract\ValidationReport;
use kikimarik\validation\contract\ValidationRequest;
use kikimarik\validation\contract\ValidationRule;
use kikimarik\validation\contract\ValidationRuntimeException;
use kikimarik\validation\exception\InvalidValidationField;
use kikimarik\validation\field\Unfilled;

abstract class AbstractValidationRequest implements ValidationRequest
{
    private ValidationReport $report;
    /** @var array<string,ValidationRule> */
    private array $rules;

    public function __construct(ValidationReport $report)
    {
        $this->report = $report;
        $this->rules = [];
    }

    public function add(string $field, ValidationRule $rule): AbstractValidationRequest
    {
        if ($field === "") {
            throw new InvalidValidationField("The field to be added must not be empty.");
        }
        $fields = explode("|", $field);
        foreach ($fields as $field) {
            $this->rules[trim($field)] = $rule;
        }
        return $this;
    }

    /**
     * @throws ValidationRuntimeException
     */
    public function validate(array $payload): ValidationReport
    {
        foreach ($this->rules as $field => $rule) {
            $item = array_key_exists($field, $payload) ? $payload[$field] : new Unfilled();
            $this->validateOne($item, $field, $rule);
        }
        return $this->report;
    }

    /**
     * @param mixed $item
     * @throws ValidationRuntimeException
     */
    protected function validateOne($item, string $field, ValidationRule $rule): void
    {
        if (!$rule->check($item)) {
            $this->report->add($field, $rule->fail());
        }
    }
}

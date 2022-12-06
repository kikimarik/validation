<?php

namespace kikimarik\validation\rule;

use kikimarik\validation\contract\ValidationError;
use kikimarik\validation\contract\ValidationRule;
use kikimarik\validation\error\MultipleValidationError;
use kikimarik\validation\exception\ValidationErrorsNotFound;

final class Group implements ValidationRule
{
    /**
     * @var array<ValidationRule>
     */
    private array $rules;
    /**
     * @var array<ValidationError>
     */
    private array $errors;

    public function __construct(ValidationRule ... $rules)
    {
        $this->rules = $rules;
        $this->errors = [];
    }

    /**
     * @inheritDoc
     */
    public function check($value): bool
    {
        $isValidAll = true;
        foreach ($this->rules as $rule) {
            $isValid = $rule->check($value);
            if (!$isValid) {
                $this->errors[] = $rule->fail();
                $isValidAll = false;
            }
        }
        return $isValidAll;
    }

    /**
     * @inheritDoc
     */
    public function fail(): ValidationError
    {
        if (count($this->errors) === 0) {
            throw new ValidationErrorsNotFound(self::class);
        }
        $errors = [];
        foreach ($this->errors as $error) {
            $errors[] = $error->read();
        }
        return new MultipleValidationError($errors);
    }
}

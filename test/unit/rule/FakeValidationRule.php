<?php

namespace kikimarik\validation\test\unit\rule;

use kikimarik\validation\contract\ValidationError;
use kikimarik\validation\contract\ValidationRule;
use kikimarik\validation\field\Unfilled;
use kikimarik\validation\test\unit\error\FakeValidationError;

final class FakeValidationRule implements ValidationRule
{
    private string $expected;

    public function __construct(string $actual)
    {
        $this->expected = $actual;
    }

    /**
     * @inheritDoc
     */
    public function check($value): bool
    {
        if ($value instanceof Unfilled) {
            return true;
        }
        return $value === $this->expected;
    }

    /**
     * @inheritDoc
     */
    public function fail(): ValidationError
    {
        return new FakeValidationError($this->expected);
    }
}

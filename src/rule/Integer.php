<?php

namespace kikimarik\validation\rule;

use kikimarik\validation\contract\ValidationError;
use kikimarik\validation\contract\ValidationRule;
use kikimarik\validation\error\MatchValidationError;
use kikimarik\validation\field\Unfilled;

final class Integer implements ValidationRule
{
    private const MIN = -2147483648;
    private const MAX = 2147483647;
    private int $min;
    private int $max;
    private string $errorMessage;

    public function __construct(int $min = self::MIN, int $max = self::MAX, ?string $errorMessage = null) {
        $this->min = $min;
        $this->max = $max;
        $this->errorMessage = $errorMessage ?? "Does not match an integer from $min to $max.";
    }

    /**
     * @inheritDoc
     */
    public function check($value): bool
    {
        /**
         * TODO refactor that
         */
        if ($value instanceof Unfilled) {
            return true;
        }
        if (!is_integer($value)) {
            return false;
        }
        if ($value < $this->min || $value > $this->max) {
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function fail(): ValidationError
    {
        return new MatchValidationError($this->errorMessage);
    }
}

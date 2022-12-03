<?php

namespace kikimarik\validation\error;

use kikimarik\validation\contract\ValidationError;

final class MatchValidationError implements ValidationError
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function read(): string
    {
        return $this->text;
    }
}

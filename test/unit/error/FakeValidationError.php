<?php

namespace kikimarik\validation\test\unit\error;

use kikimarik\validation\contract\ValidationError;

final class FakeValidationError implements ValidationError
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
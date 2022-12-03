<?php

namespace kikimarik\validation\contract;

use Iterator;

interface ValidationReport
{
    public function add(string $field, ValidationError $error): self;

    public function hasErrors(): bool;
}

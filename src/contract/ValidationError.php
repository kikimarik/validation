<?php

namespace kikimarik\validation\contract;

interface ValidationError
{
    public function read(): string;
}

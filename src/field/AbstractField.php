<?php

namespace kikimarik\validation\field;

use kikimarik\validation\contract\ValidationField;

abstract class AbstractField implements ValidationField
{
    public function refer(): string
    {
        return static::class;
    }
}

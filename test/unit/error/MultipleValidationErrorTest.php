<?php

namespace kikimarik\validation\test\unit\error;

use kikimarik\validation\error\MultipleValidationError;
use PHPUnit\Framework\TestCase;

final class MultipleValidationErrorTest extends TestCase
{
    public function testRead(): void
    {
        $text = "foo; bar";
        $error = new MultipleValidationError(["foo", "bar"]);
        $result = $error->read();
        $this->assertEquals($text, $result);
    }
}

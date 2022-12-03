<?php

namespace kikimarik\validation\test\unit\error;

use kikimarik\validation\error\MatchValidationError;
use PHPUnit\Framework\TestCase;

final class MatchValidationErrorTest extends TestCase
{
    public function testRead(): void
    {
        $text = "foo";
        $error = new MatchValidationError($text);
        $result = $error->read();
        $this->assertEquals($text, $result);
    }
}

<?php

namespace kikimarik\validation\test\unit\field;

use kikimarik\validation\field\Unfilled;
use PHPUnit\Framework\TestCase;

final class UnfilledTest extends TestCase
{
    public function testRefer(): void
    {
        $field = new Unfilled();
        $result = $field->refer();
        $this->assertEquals(Unfilled::class, $result);
    }
}

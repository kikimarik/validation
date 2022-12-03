<?php

namespace kikimarik\validation\test\unit\rule;

use kikimarik\validation\contract\ValidationError;
use kikimarik\validation\contract\ValidationRuntimeException;
use kikimarik\validation\error\MatchValidationError;
use kikimarik\validation\field\Unfilled;
use kikimarik\validation\rule\Integer as IntegerRule;
use PHPUnit\Framework\TestCase;

final class IntegerTest extends TestCase
{
    /**
     * @dataProvider createCheckData
     * @param mixed $value
     */
    public function testCheck(bool $expected, $value, ?int $min = null, ?int $max = null): void
    {
        $rule = $this->createInteger($min, $max, null);
        try {
            $result = $rule->check($value);
            $this->assertEquals($expected, $result);
        } catch (ValidationRuntimeException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @dataProvider createFailData
     */
    public function testFail(ValidationError $expected, ?string $errorText, ?int $min = null, ?int $max = null): void
    {
        $rule = $this->createInteger($min, $max, $errorText);
        try {
            $result = $rule->fail();
            $this->assertEquals($expected, $result);
        } catch (ValidationRuntimeException $e) {
            $this->fail($e->getMessage());
        }
    }

    private function createInteger(?int $min, ?int $max, ?string $errorText): IntegerRule
    {
        if (isset($min, $max, $errorText)) {
            $rule = new IntegerRule($min, $max, $errorText);
        } elseif (isset($min, $max)) {
            $rule = new IntegerRule($min, $max);
        } elseif (isset($min)) {
            $rule = new IntegerRule($min);
        } elseif (isset($errorText)) {
            $rule = new IntegerRule(0, 1, $errorText);
        } else {
            $rule = new IntegerRule();
        }
        return $rule;
    }

    /**
     * @return array<array<mixed>>
     */
    public function createCheckData(): array
    {
        return [
            [true, new Unfilled()],
            [true, 0],
            [true, 0, -1, 0],
            [true, 0, 0, 1],
            [true, 0, 0, 0],
            [false, -1, 0, 1],
            [false, 1, -1, 0],
            [false, ""],
            [false, []],
            [false, 1.01],
            [false, new class {}],
            [false, function () {}],
        ];
    }

    /**
     * @return array<array<mixed>>
     */
    public function createFailData(): array
    {
        return [
            [new MatchValidationError("foo"), "foo"],
            [new MatchValidationError("Does not match an integer from 0 to 1."), null, 0, 1],
        ];
    }
}

<?php

namespace kikimarik\validation\test\unit\rule;

use kikimarik\validation\contract\ValidationError;
use kikimarik\validation\contract\ValidationRuntimeException;
use kikimarik\validation\error\MultipleValidationError;
use kikimarik\validation\exception\ValidationErrorsNotFound;
use kikimarik\validation\rule\Group;
use PHPUnit\Framework\TestCase;

final class GroupTest extends TestCase
{
    /**
     * @dataProvider createCheckData
     * @param mixed $value
     */
    public function testCheck(bool $expected, string $first, string $second, $value): void
    {
        $rule = new Group(
            new FakeValidationRule($first),
            new FakeValidationRule($second)
        );
        try {
            $result = $rule->check($value);
            $this->assertEquals($expected, $result);
        } catch (ValidationRuntimeException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @dataProvider createFailData
     * @param mixed $value
     */
    public function testFail(ValidationError $expected, string $first, string $second, $value): void
    {
        $rule = new Group(
            new FakeValidationRule($first),
            new FakeValidationRule($second)
        );
        try {
            $rule->check($value);
            $result = $rule->fail();
            $this->assertEquals($expected, $result);
        } catch (ValidationRuntimeException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @throws ValidationRuntimeException
     */
    public function testFailNegative(): void
    {
        $this->expectException(ValidationErrorsNotFound::class);
        $rule = new Group(
            new FakeValidationRule("foo"),
            new FakeValidationRule("bar")
        );
        $rule->fail();
    }

    /**
     * @return array<array<mixed>>
     */
    public function createCheckData(): array
    {
        return [
            [true, "foo", "foo", "foo"],
            [false, "foo", "foo", "bar"],
            [false, "foo", "bar", "bar"],
            [false, "foo", "foo", 0],
        ];
    }

    /**
     * @return array<array<mixed>>
     */
    public function createFailData(): array
    {
        return [
            [new MultipleValidationError(["foo", "foo"]), "foo", "foo", "bar"],
            [new MultipleValidationError(["foo"]), "foo", "bar", "bar"],
            [new MultipleValidationError(["bar"]), "foo", "bar", "foo"],
        ];
    }
}

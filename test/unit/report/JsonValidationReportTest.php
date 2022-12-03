<?php

namespace kikimarik\validation\test\unit\report;

use kikimarik\validation\contract\ValidationError;
use kikimarik\validation\report\JsonValidationReport;
use kikimarik\validation\test\unit\error\FakeValidationError;
use PHPUnit\Framework\TestCase;

final class JsonValidationReportTest extends TestCase
{
    public function testAdd(): void
    {
        $expected = json_encode(
            [
                "errors" => [
                    "foo" => "bar",
                    "bar" => "foo"
                ]
            ]
        );
        $report = new JsonValidationReport();
        $result = $report
            ->add("foo", new FakeValidationError("bar"))
            ->add("bar", new FakeValidationError("foo"));
        $this->assertEquals($report, $result);
        $this->assertEquals($expected, json_encode($result));
    }
}

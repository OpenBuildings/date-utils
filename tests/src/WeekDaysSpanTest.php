<?php

namespace CL\DateUtils\Test;

use PHPUnit\Framework\TestCase;
use CL\DateUtils\WeekDaysSpan;
use CL\DateUtils\WeekDays;

/**
 * @coversDefaultClass CL\DateUtils\WeekDaysSpan
 */
class WeekDaysSpanTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getFrom
     * @covers ::getTo
     */
    public function testConstruct()
    {
        $from = new WeekDays(5);
        $to = new WeekDays(10);

        $span = new WeekDaysSpan($from, $to);

        $this->assertSame($from, $span->getFrom());
        $this->assertSame($to, $span->getTo());
    }

    public function dataHumanize()
    {
        return [
            [new WeekDaysSpan(new WeekDays(5), new WeekDays(10)), '5 - 10 week days'],
            [new WeekDaysSpan(new WeekDays(5), new WeekDays(5)), '5 week days'],
            [new WeekDaysSpan(new WeekDays(15), new WeekDays(12)), '15 - 12 week days'],
        ];
    }

    /**
     * @covers ::humanize
     * @dataProvider dataHumanize
     */
    public function testHumanize($input, $result)
    {
        $this->assertSame($result, $input->humanize());
    }
}

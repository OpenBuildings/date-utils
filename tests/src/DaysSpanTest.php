<?php

namespace CL\DateUtils\Test;

use PHPUnit_Framework_TestCase;
use CL\DateUtils\DaysSpan;
use CL\DateUtils\WeekDays;
use CL\DateUtils\Days;
use CL\DateUtils\DateTimeSpan;
use DateTime;

/**
 * @coversDefaultClass CL\DateUtils\DaysSpan
 */
class DaysSpanTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getFrom
     * @covers ::getTo
     */
    public function testConstruct()
    {
        $from = new Days(5);
        $to = new Days(10);

        $span = new DaysSpan($from, $to);

        $this->assertSame($from, $span->getFrom());
        $this->assertSame($to, $span->getTo());
    }

    public function dataToDateTimeSpan()
    {
        return [
            [
                new Days(5), new Days(10),
                new DateTime('2015-02-02'),
                new DateTimeSpan(new DateTime('2015-02-07'), new DateTime('2015-02-12')),
            ],
            [
                new WeekDays(5), new WeekDays(10),
                new DateTime('2015-02-02'),
                new DateTimeSpan(new DateTime('2015-02-09'), new DateTime('2015-02-16')),
            ],
        ];
    }

    /**
     * @covers ::toDateTimeSpan
     * @dataProvider dataToDateTimeSpan
     */
    public function testToDateTime($from, $to, $start, $result)
    {
        $span = new DaysSpan($from, $to);

        $this->assertEquals($result, $span->toDateTimeSpan($start));
    }

    public function dataHumanize()
    {
        return [
            [new DaysSpan(new Days(5), new Days(10)), '5 - 10 days'],
            [new DaysSpan(new Days(5), new Days(5)), '5 days'],
            [new DaysSpan(new Days(15), new Days(12)), '15 - 12 days'],
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

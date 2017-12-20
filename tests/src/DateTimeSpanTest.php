<?php

namespace CL\DateUtils\Test;

use PHPUnit\Framework\TestCase;
use CL\DateUtils\DateTimeSpan;
use DateTime;

/**
 * @coversDefaultClass CL\DateUtils\DateTimeSpan
 */
class DateTimeSpanTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getFrom
     * @covers ::getTo
     */
    public function testConstruct()
    {
        $from = new DateTime('2014-12-01');
        $to = new DateTime('2016-03-02');

        $span = new DateTimeSpan($from, $to);

        $this->assertSame($from, $span->getFrom());
        $this->assertSame($to, $span->getTo());
    }


    public function dataContains()
    {
        return [
            [new DateTime('2015-05-02'), new DateTime('2015-05-05'), new DateTime('2015-05-03'), true],
            [new DateTime('2015-05-01'), new DateTime('2016-02-10'), new DateTime('2015-07-07'), true],
            [new DateTime('2015-02-01'), new DateTime('2015-02-10'), new DateTime('2015-07-07'), false],
        ];}

    /**
     * @covers ::contains
     * @dataProvider dataContains
     */
    public function testContains($from, $to, $date, $result)
    {
        $span = new DateTimeSpan($from, $to);

        $this->assertSame($result, $span->contains($date));
    }

    public function dataHumanize()
    {
        return [
            [new DateTimeSpan(new DateTime('2015-05-02'), new DateTime('2015-05-02')), '2 May 2015'],
            [new DateTimeSpan(new DateTime('2015-05-02'), new DateTime('2015-05-08')), '2 - 8 May 2015'],
            [new DateTimeSpan(new DateTime('2015-05-02'), new DateTime('2015-06-08')), '2 May - 8 Jun 2015'],
            [new DateTimeSpan(new DateTime('2015-05-02'), new DateTime('2016-02-01')), '2 May 2015 - 1 Feb 2016'],
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


    public function dataGetBusinessDaysInPeriodFrom()
    {
        return [
            [new DateTime('today'), new DateTime(), null, 0],
            [new DateTime('today'), new DateTime(), new DateTime('today'), 0],
            [new DateTime('tomorrow'), new DateTime(), new DateTime('today'), 1],
            [new DateTime('monday next week'), new DateTime(), new DateTime('monday this week'), 5],
            [new DateTime('friday next week'), new DateTime(), new DateTime('monday this week'), 9],
            [new DateTime('today'), new DateTime(), new DateTime('tomorrow'), 0],
        ];
    }

    /**
     * @covers ::getBusinessDaysInPeriodFrom
     * @covers ::calculateBusinessDaysInPeriod
     * @dataProvider dataGetBusinessDaysInPeriodFrom
     */
    public function testGetBusinessDaysInPeriodFrom($from, $to, $startDate, $result)
    {
        $span = new DateTimeSpan($from, $to);

        $this->assertSame($result, $span->getBusinessDaysInPeriodFrom($startDate));
    }

    public function dataGetBusinessDaysInPeriodTo ()
    {
        return [
            [new DateTime(), new DateTime('today'), null, 0],
            [new DateTime(), new DateTime('today'), new DateTime('today'), 0],
            [new DateTime(), new DateTime('tomorrow'), new DateTime('today'), 1],
            [new DateTime(), new DateTime('monday next week'), new DateTime('monday this week'), 5],
            [new DateTime(), new DateTime('friday next week'), new DateTime('monday this week'), 9],
            [new DateTime(), new DateTime('today'), new DateTime('tomorrow'), 0],
        ];
    }

    /**
     * @covers ::getBusinessDaysInPeriodFrom
     * @covers ::calculateBusinessDaysInPeriod
     * @dataProvider dataGetBusinessDaysInPeriodTo
     */
    public function testGetBusinessDaysInPeriodTo($from, $to, $startDate, $result)
    {
        $span = new DateTimeSpan($from, $to);

        $this->assertSame($result, $span->getBusinessDaysInPeriodTo($startDate));
    }
}

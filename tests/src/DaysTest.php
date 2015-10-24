<?php

namespace CL\DateUtils\Test;

use PHPUnit_Framework_TestCase;
use CL\DateUtils\Days;
use DateTime;

/**
 * @coversDefaultClass CL\DateUtils\Days
 */
class DaysTest extends PHPUnit_Framework_TestCase
{
    public function dataConstruct()
    {
        return [
            [5, 5],
            ['235', 235],
            ['sdhfk', 0],
        ];
    }

    /**
     * @covers ::__construct
     * @covers ::getDays
     * @dataProvider dataConstruct
     */
    public function testConstruct($input, $result)
    {
        $days = new Days($input);

        $this->assertSame($result, $days->getDays());
    }

    /**
     * @covers ::add
     */
    public function testAdd()
    {
        $day1 = new Days(7);
        $day2 = new Days(13);

        $expected = new Days(20);

        $this->assertEquals($expected, $day1->add($day2));
    }

    public function dataGetNewStartDate()
    {
        return [
            [null, new DateTime('now')],
            [new DateTime('2015-02-02'), new DateTime('2015-02-02')],
        ];
    }

    /**
     * @covers ::getNewStartDate
     * @dataProvider dataGetNewStartDate
     */
    public function testGetNewStartDate($start, $expected)
    {
        $days = new Days(1);

        $result = $days->getNewStartDate($start);

        $this->assertEquals($expected->format('d m Y'), $result->format('d m Y'));
    }

    public function dataToDateTime()
    {
        return [
            [5, new DateTime('2015-02-02'), new DateTime('2015-02-07')],
            [30, new DateTime('2015-03-01'), new DateTime('2015-03-31')],
        ];
    }

    /**
     * @covers ::toDateTime
     * @dataProvider dataToDateTime
     */
    public function testToDateTime($input, $start, $result)
    {
        $days = new Days($input);

        $this->assertEquals($result->format('d m Y'), $days->toDateTime($start)->format('d m Y'));
    }

    public function dataHumanize()
    {
        return [
            [new Days(5), '5 days'],
            [new Days('235'), '235 days'],
            [new Days('sdhfk'), '0 days'],
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

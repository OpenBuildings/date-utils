<?php

namespace CL\DateUtils\Test;

use PHPUnit_Framework_TestCase;
use CL\DateUtils\DateTimeSpan;
use CL\DateUtils\Holidays;
use DateTime;

/**
 * @coversDefaultClass CL\DateUtils\Holidays
 */
class HolidaysTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getDates
     * @covers ::add
     */
    public function testConstruct()
    {
        $outOfOrderDates = [
            new DateTime('2015-02-05'),
            new DateTime('2015-02-02'),
            new DateTime('2015-02-03'),
        ];

        $holidays = new Holidays($outOfOrderDates);

        $expected = [
            new DateTime('2015-02-02'),
            new DateTime('2015-02-03'),
            new DateTime('2015-02-05'),
        ];

        $this->assertEquals($expected, $holidays->getDates());
    }

    /**
     * @covers ::addDateTimeSpan
     */
    public function testAddDateTimeSpan()
    {
        $holidays = new Holidays();
        $span = new DateTimeSpan(new DateTime('2015-06-17'), new DateTime('2015-06-23'));
        $holidays->addDateTimeSpan($span);

        $expected = [
            new DateTime('2015-06-17'),
            new DateTime('2015-06-18'),
            new DateTime('2015-06-19'),
            new DateTime('2015-06-20'),
            new DateTime('2015-06-21'),
            new DateTime('2015-06-22'),
            new DateTime('2015-06-23'),
        ];

        $this->assertEquals($expected, $holidays->getDates());

        $holidays = new Holidays();
        $span = new DateTimeSpan(new DateTime('2015-06-20'), new DateTime('2015-06-23'));
        $holidays->addDateTimeSpan($span);

        $expected = [
            new DateTime('2015-06-20'),
            new DateTime('2015-06-21'),
            new DateTime('2015-06-22'),
            new DateTime('2015-06-23'),
        ];

        $this->assertEquals($expected, $holidays->getDates());

        $holidays = new Holidays();
        $span = new DateTimeSpan(new DateTime('2015-06-19'), new DateTime('2015-06-23'));
        $holidays->addDateTimeSpan($span);

        $expected = [
            new DateTime('2015-06-19'),
            new DateTime('2015-06-20'),
            new DateTime('2015-06-21'),
            new DateTime('2015-06-22'),
            new DateTime('2015-06-23'),
        ];

        $this->assertEquals($expected, $holidays->getDates());
    }

    /**
     * @covers ::extendDateTimeSpan
     */
    public function testExtendDateTimeSpan()
    {
        $holidays = new Holidays([
            new DateTime('2015-06-17'),
            new DateTime('2015-06-18'),
            new DateTime('2015-06-19'),
            new DateTime('2015-06-20'),
            new DateTime('2015-06-21'),
            new DateTime('2015-06-22'),
            new DateTime('2015-06-23'),
        ]);

        $span = new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-06-30'));

        $result = $holidays->extendDateTimeSpan($span);

        $expected = new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-07-07'));

        $this->assertEquals($expected, $result);

        $holidays = new Holidays([
            new DateTime('2015-06-17'),
            new DateTime('2015-06-18'),
            new DateTime('2015-06-19'),
            new DateTime('2015-06-20'),
            new DateTime('2015-06-21'),
            new DateTime('2015-06-22'),
            new DateTime('2015-06-23'),
        ]);

        $span = new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-06-30'));

        $result = $holidays->extendDateTimeSpan($span);

        $expected = new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-07-07'));

        $this->assertEquals($expected, $result);
    }
}

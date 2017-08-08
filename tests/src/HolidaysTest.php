<?php

namespace CL\DateUtils\Test;

use PHPUnit\Framework\TestCase;
use CL\DateUtils\DateTimeSpan;
use CL\DateUtils\Holidays;
use DateTime;

/**
 * @coversDefaultClass CL\DateUtils\Holidays
 */
class HolidaysTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getDates
     * @covers ::add
     * @covers ::count
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
        $this->assertCount(3, $holidays);
    }

    /**
     * @covers ::isEmpty
     */
    public function testIsEmpty()
    {
        $holidays = new Holidays();
        $this->assertTrue($holidays->isEmpty());

        $holidays = new Holidays([new DateTime('2015-02-02')]);
        $this->assertFalse($holidays->isEmpty());
    }

    /**
     * @covers ::isActive
     */
    public function testIsActive()
    {
        $holidays = new Holidays([
            new DateTime('2015-02-02'),
            new DateTime('2015-02-03'),
            new DateTime('2015-02-05'),
        ]);

        $this->assertTrue($holidays->isActive(new DateTime('2015-02-02')));
        $this->assertTrue($holidays->isActive(new DateTime('2015-02-03')));
        $this->assertFalse($holidays->isActive(new DateTime('2015-02-04')));
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

    public function dataExtendDateTimeSpan()
    {
        return [
            [
                new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-06-30')),
                null,
                new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-07-07')),
            ],
            [
                new DateTimeSpan(new DateTime('2015-06-17'), new DateTime('2015-06-30')),
                null,
                new DateTimeSpan(new DateTime('2015-06-24'), new DateTime('2015-07-07')),
            ],
            [
                new DateTimeSpan(new DateTime('2015-06-19'), new DateTime('2015-06-22')),
                null,
                new DateTimeSpan(new DateTime('2015-06-26'), new DateTime('2015-06-29')),
            ],
            [
                new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-06-22')),
                null,
                new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-06-29')),
            ],
            [
                new DateTimeSpan(new DateTime('2015-06-19'), new DateTime('2015-06-22')),
                new DateTime('2015-06-18'),
                new DateTimeSpan(new DateTime('2015-06-25'), new DateTime('2015-06-28')),
            ]
        ];
    }

    /**
     * @covers ::extendDateTimeSpan
     * @dataProvider dataExtendDateTimeSpan
     */
    public function testExtendDateTimeSpan($span, $start_date, $expected)
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

        $result = $holidays->extendDateTimeSpan($span, $start_date);

        $this->assertEquals($expected, $result);
    }

    public function dataExtendBusinessDateTimeSpan()
    {
        return [
            [
                new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-06-30')),
                null,
                new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-07-03')),
            ],
            [
                new DateTimeSpan(new DateTime('2015-06-17'), new DateTime('2015-06-30')),
                null,
                new DateTimeSpan(new DateTime('2015-06-22'), new DateTime('2015-07-03')),
            ],
            [
                new DateTimeSpan(new DateTime('2015-06-19'), new DateTime('2015-06-22')),
                null,
                new DateTimeSpan(new DateTime('2015-06-24'), new DateTime('2015-06-25')),
            ],
            [
                new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-06-22')),
                null,
                new DateTimeSpan(new DateTime('2015-06-12'), new DateTime('2015-06-25')),
            ],
            [
                new DateTimeSpan(new DateTime('2015-06-19'), new DateTime('2015-06-22')),
                new DateTime('2015-06-18'),
                new DateTimeSpan(new DateTime('2015-06-23'), new DateTime('2015-06-24')),
            ]
        ];
    }

    /**
     * @covers ::extendBusinessDateTimeSpan
     * @dataProvider dataExtendBusinessDateTimeSpan
     */
    public function testExtendBusinessDateTimeSpan($span, $start_date, $expected)
    {
        $holidays = new Holidays([
            new DateTime('2015-06-17'),
            new DateTime('2015-06-18'),
            new DateTime('2015-06-19'),
            new DateTime('2015-06-20'),
            new DateTime('2015-06-21'),
        ]);

        $result = $holidays->extendBusinessDateTimeSpan($span, $start_date);

        $this->assertEquals($expected, $result);
    }
}

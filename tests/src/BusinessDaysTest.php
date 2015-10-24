<?php

namespace CL\DateUtils\Test;

use PHPUnit_Framework_TestCase;
use CL\DateUtils\BusinessDays;
use CL\DateUtils\Holidays;
use DateTime;

/**
 * @coversDefaultClass CL\DateUtils\BusinessDays
 */
class BusinessDaysTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getHolidays
     * @covers ::setHolidays
     */
    public function testConstruct()
    {
        $holidays = new Holidays();
        $days = new BusinessDays(10, $holidays);

        $this->assertSame(10, $days->getDays());
        $this->assertSame($holidays, $days->getHolidays());

        $holidays2 = new Holidays();

        $days->setHolidays($holidays2);
        $this->assertSame($holidays2, $days->getHolidays());
    }

    public function dataToDateTime()
    {
        return [
            [
                5,
                null,
                new DateTime('2015-02-02'),
                new DateTime('2015-02-9')
            ],
            [
                5,
                new Holidays([new DateTime('2015-02-04'), new DateTime('2015-02-05')]),
                new DateTime('2015-02-02'),
                new DateTime('2015-02-11')
            ],
            [
                40,
                null,
                new DateTime('2015-02-02'),
                new DateTime('2015-02-02 + 40 weekdays')
            ],

            // Test workaround for PHP 5.4 bug with weekdays and Sundays
            [
                5,
                null,
                new DateTime('2015-06-20'),
                new DateTime('2015-06-26'),
            ],
        ];
    }

    /**
     * @covers ::toDateTime
     * @dataProvider dataToDateTime
     */
    public function testToDateTime($input, $holidays, $start, $result)
    {
        $days = new BusinessDays($input, $holidays);

        $this->assertEquals($result->format('d m Y'), $days->toDateTime($start)->format('d m Y'));
    }

    public function dataHumanize()
    {
        return [
            [new BusinessDays(5), '5 business days'],
            [new BusinessDays('235'), '235 business days'],
            [new BusinessDays('sdhfk'), '0 business days'],
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

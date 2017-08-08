<?php

namespace CL\DateUtils\Test;

use PHPUnit\Framework\TestCase;
use CL\DateUtils\BusinessDaysSpan;
use CL\DateUtils\BusinessDays;
use CL\DateUtils\Holidays;

/**
 * @coversDefaultClass CL\DateUtils\BusinessDaysSpan
 */
class BusinessDaysSpanTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getFrom
     * @covers ::getTo
     * @covers ::setHolidays
     */
    public function testConstruct()
    {
        $from = new BusinessDays(5);
        $to = new BusinessDays(10);

        $span = new BusinessDaysSpan($from, $to);

        $this->assertSame($from, $span->getFrom());
        $this->assertSame($to, $span->getTo());

        $holidays = new Holidays();

        $span->setHolidays($holidays);

        $this->assertSame($holidays, $span->getFrom()->getHolidays());
        $this->assertSame($holidays, $span->getTo()->getHolidays());
    }

    public function dataHumanize()
    {
        return [
            [new BusinessDaysSpan(new BusinessDays(5), new BusinessDays(10)), '5 - 10 business days'],
            [new BusinessDaysSpan(new BusinessDays(5), new BusinessDays(5)), '5 business days'],
            [new BusinessDaysSpan(new BusinessDays(15), new BusinessDays(12)), '15 - 12 business days'],
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

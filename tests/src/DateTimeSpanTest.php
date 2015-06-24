<?php

namespace CL\DateUtils\Test;

use PHPUnit_Framework_TestCase;
use CL\DateUtils\DateTimeSpan;
use DateTime;

/**
 * @coversDefaultClass CL\DateUtils\DateTimeSpan
 */
class DateTimeSpanTest extends PHPUnit_Framework_TestCase
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
    public function testDateTimeSpan($input, $result)
    {
        $this->assertSame($result, $input->humanize());
    }
}

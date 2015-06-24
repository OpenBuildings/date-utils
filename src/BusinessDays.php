<?php

namespace CL\DateUtils;

use DateTime;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class BusinessDays extends Days
{
    private $holidays = null;

    public function __construct($days, Holidays $holidays = null)
    {
        parent::__construct($days);

        $this->holidays = $holidays;
    }

    public function getHolidays()
    {
        return $this->holidays;
    }

    public function toDateTime(DateTime $start = null)
    {
        if ($start === null) {
            $start = new DateTime('now');
        } else {
            $start = clone $start;
        }

        $end = clone $start;
        $end->modify("+ {$this->getDays()} weekdays");

        if ($this->holidays) {
            $span = new DateTimeSpan($start, $end);
            $span = $this->holidays->extendDateTimeSpan($span);

            return $span->getTo();
        }

        return $end;
    }

    public function humanize()
    {
        return "{$this->getDays()} business days";
    }
}
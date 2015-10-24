<?php

namespace CL\DateUtils;

use DateTime;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class BusinessDays extends WeekDays
{
    /**
     * @var Holidays|null
     */
    private $holidays = null;

    /**
     * @param integer       $days
     * @param Holidays|null $holidays
     */
    public function __construct($days, Holidays $holidays = null)
    {
        parent::__construct($days);

        $this->holidays = $holidays;
    }

    /**
     * @return Holidays|null
     */
    public function getHolidays()
    {
        return $this->holidays;
    }

    /**
     * @param Holidays $holidays
     */
    public function setHolidays(Holidays $holidays)
    {
        $this->holidays = $holidays;

        return $this;
    }

    /**
     * @param  DateTime|null $start
     * @return DateTime
     */
    public function toDateTime(DateTime $start = null)
    {
        $end = parent::toDateTime($this->getNewStartDate($start));

        if ($this->holidays) {
            $span = new DateTimeSpan($start, $end);
            $span = $this->holidays->extendDateTimeSpan($span);

            return $span->getTo();
        }

        return $end;
    }

    /**
     * @return string
     */
    public function humanize()
    {
        return "{$this->getDays()} business days";
    }
}

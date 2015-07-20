<?php

namespace CL\DateUtils;

use DateTime;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Holidays
{
    /**
     * @var DateTime[]
     */
    private $days;

    public function __construct(array $days = array())
    {
        foreach ($days as $day) {
            $this->add($day);
        }
    }

    /**
     * @return DateTime[]
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param DateTime $current
     * @param DateTime $to
     */
    public function addDateTimeSpan(DateTimeSpan $span)
    {
        $current = clone $span->getFrom();

        while ($current <= $span->getTo()) {
            // Check if it's not during the weekend
            if (6 > (int) $current->format('N')) {
                $this->add($current);
            }

            $current = clone $current;
            $current = WeekDays::ensureWeekdays($current->modify('+1 weekday'));
        }

        return $this;
    }

    /**
     * @param DateTime $day
     */
    public function add(DateTime $day)
    {
        $this->days []= $day;

        sort($this->days);

        return $this;
    }

    /**
     * @param  DateTime $from
     * @param  DateTime $date
     * @return DateTime
     */
    public function extendDateTimeSpan(DateTimeSpan $span)
    {
        $to = clone $span->getTo();

        foreach ($this->days as $holiday) {
            if ($holiday > $span->getFrom() and $holiday < $to) {
                $to = WeekDays::ensureWeekdays($to->modify('+1 weekday'));
            }
        }

        return new DateTimeSpan($span->getFrom(), $to);
    }
}

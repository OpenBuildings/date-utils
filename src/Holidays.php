<?php

namespace CL\DateUtils;

use DateTime;
use Countable;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Holidays implements Countable
{
    /**
     * @var DateTime[]
     */
    private $dates;

    public function __construct(array $dates = array())
    {
        foreach ($dates as $date) {
            $this->add($date);
        }
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->dates);
    }

    /**
     * Implement countable
     *
     * @return integer
     */
    public function count()
    {
        return count($this->dates);
    }

    /**
     * @return DateTime[]
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param DateTime $current
     * @param DateTime $to
     */
    public function addDateTimeSpan(DateTimeSpan $span)
    {
        $current = clone $span->getFrom();

        while ($current <= $span->getTo()) {
            $this->add($current);

            $current = clone $current;
            $current->modify('+1 day');
        }

        return $this;
    }

    /**
     * @param DateTime $day
     */
    public function add(DateTime $day)
    {
        $this->dates []= $day;

        sort($this->dates);

        return $this;
    }

    /**
     * Check if a date is within any holiday
     *
     * @param  DateTime $date
     * @return boolean
     */
    public function has(DateTime $date)
    {
        foreach ($this->dates as $holiday) {
            if ($date->format('Y-m-d') == $holiday->format('Y-m-d')) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  DateTime $from
     * @param  DateTime $date
     * @return DateTime
     */
    public function extendDateTimeSpan(DateTimeSpan $span)
    {
        $to = clone $span->getTo();

        foreach ($this->dates as $holiday) {
            if ($holiday > $span->getFrom() and $holiday < $to) {
                $to->modify('+1 day');
            }
        }

        return new DateTimeSpan($span->getFrom(), $to);
    }
}

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
    private $dates = [];

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
    public function isActive(DateTime $date = null)
    {
        $date = $date ?: new DateTime();

        foreach ($this->dates as $holiday) {
            if ($date->format('Y-m-d') == $holiday->format('Y-m-d')) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  DateTimeSpan $span
     * @param  DateTime $start_date
     * @return DateTimeSpan
     */
    public function extendDateTimeSpan(DateTimeSpan $span, DateTime $start_date = null)
    {
        $from = clone $span->getFrom();
        $to = clone $span->getTo();

        foreach ($this->dates as $holiday) {
            if ($start_date and $holiday < $start_date) {
                continue;
            }

            if ($holiday <= $from) {
                $from->modify('+1 day');
            }

            if ($holiday <= $to) {
                $to->modify('+1 day');
            }
        }

        return new DateTimeSpan($from, $to);
    }

    /**
     * @param  DateTimeSpan $span
     * @param  DateTime $start_date
     * @return DateTimeSpan
     */
    public function extendBusinessDateTimeSpan(DateTimeSpan $span, DateTime $start_date = null)
    {
        $from = clone $span->getFrom();
        $to = clone $span->getTo();

        foreach ($this->dates as $holiday) {
            if (($start_date and $holiday < $start_date) or 5 < $holiday->format('N')) {
                continue;
            }

            if ($holiday <= $from) {
                $from->modify('+1 weekday');
            }

            if ($holiday <= $to) {
                $to->modify('+1 weekday');
            }
        }

        return new DateTimeSpan($from, $to);
    }
}

<?php

namespace CL\DateUtils;

use DateInterval;
use DatePeriod;
use DateTime;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class DateTimeSpan
{
    /**
     * @var DateTime
     */
    private $from;

    /**
     * @var DateTime
     */
    private $to;

    public function __construct(DateTime $from, DateTime $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom(): DateTime
    {
        return $this->from;
    }

    public function getTo(): DateTime
    {
        return $this->to;
    }

    public function contains(DateTime $datetime): bool
    {
        return $this->from < $datetime and $this->to > $datetime;
    }

    public function humanize(): string
    {
        $from = $this->getFrom();
        $to = $this->getTo();

        if ($from->format('Y') == $to->format('Y')) {
            if ($from->format('m') == $to->format('m')) {
                if ($from->format('d') == $to->format('d')) {
                    return $from->format('j M Y');
                } else {
                    return $from->format('j').' - '.$to->format('j').' '.$from->format('M Y');
                }
            } else {
                return $from->format('j M').' - '.$to->format('j M').' '.$from->format('Y');
            }
        }

        return $from->format('j M Y').' - '.$to->format('j M Y');
    }

    public function getBusinessDaysInPeriodFrom(DateTime $startDate = null): int
    {
        if ($startDate === null) {
            $startDate = new DateTime('today');
        }

        return $this->calculateBusinessDaysInPeriod($startDate, $this->from);
    }

    public function getBusinessDaysInPeriodTo(DateTime $startDate = null): int
    {
        if ($startDate === null) {
            $startDate = new DateTime('today');
        }

        return $this->calculateBusinessDaysInPeriod($startDate, $this->to);
    }

    private function calculateBusinessDaysInPeriod(DateTime $startDate, DateTime $endDate): int
    {
        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($startDate, $interval, $endDate);
        $workingDays = 0;
        foreach ($dateRange as $date) {
            if ($date->format('N') <= 5) {
                ++$workingDays;
            }
        }

        return $workingDays;
    }
}

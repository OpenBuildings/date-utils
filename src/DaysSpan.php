<?php

namespace CL\DateUtils;

use DateTime;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class DaysSpan
{
    /**
     * @var Days
     */
    private $from;

    /**
     * @var Days
     */
    private $to;

    /**
     * @param Days $from
     * @param Days $to
     */
    public function __construct(Days $from, Days $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return Days
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return Days
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param  DaysSpan $span
     * @return self
     */
    public function add(DaysSpan $span)
    {
        $this->from->add($span->from);
        $this->to->add($span->to);

        return $this;
    }

    /**
     * @param  DateTime $start
     * @return DateTimeSpan
     */
    public function toDateTimeSpan(DateTime $start)
    {
        return new DateTimeSpan(
            $this->from->toDateTime($start),
            $this->to->toDateTime($start)
        );
    }

    /**
     * @return string
     */
    public function humanize()
    {
        if ($this->from->getDays() == $this->to->getDays()) {
            return $this->from->getDays().' days';
        }

        return $this->from->getDays().' - '.$this->to->getDays().' days';
    }
}

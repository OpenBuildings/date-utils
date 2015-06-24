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
    private $from;
    private $to;

    public function __construct(Days $from, Days $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function toDateTimeSpan(DateTime $start)
    {
        return new DateTimeSpan(
            $this->from->toDateTime($start),
            $this->to->toDateTime($start)
        );
    }

    public function humanize()
    {
        if ($this->from->getDays() == $this->to->getDays()) {
            return $this->from->getDays().' days';
        } else {
            return $this->from->getDays().' - '.$this->to->getDays().' days';
        }
    }
}

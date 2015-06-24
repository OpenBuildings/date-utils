<?php

namespace CL\DateUtils;

use DateTime;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class WeekDays extends Days
{
    public function toDateTime(DateTime $start = null)
    {
        if ($start === null) {
            $start = new DateTime('now');
        } else {
            $start = clone $start;
        }

        return $start->modify("+ {$this->getDays()} weekdays");
    }

    public function humanize()
    {
        return "{$this->getDays()} week days";
    }
}

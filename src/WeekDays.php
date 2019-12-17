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
    /**
     * @param  DateTime|null
     * @return DateTime
     */
    public function toDateTime(DateTime $start = null)
    {
        return $this->getNewStartDate($start)->modify("+ {$this->getDays()} weekdays");
    }

    /**
     * @return string
     */
    public function humanize()
    {
        return "{$this->getDays()} week days";
    }
}

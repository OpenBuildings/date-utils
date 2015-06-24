<?php

namespace CL\DateUtils;

use DateTime;

/**
 * Force week days.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class WeekDaysSpan extends DaysSpan
{
    public function __construct(WeekDays $from, WeekDays $to)
    {
        parent::__construct($from, $to);
    }

    public function humanize()
    {
        if ($this->getFrom()->getDays() == $this->getTo()->getDays()) {
            return $this->getFrom()->getDays().' week days';
        } else {
            return $this->getFrom()->getDays().' - '.$this->getTo()->getDays().' week days';
        }
    }
}

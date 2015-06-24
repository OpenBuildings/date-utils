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
class BusinessDaysSpan extends DaysSpan
{
    public function __construct(BusinessDays $from, BusinessDays $to)
    {
        parent::__construct($from, $to);
    }

    public function setHolidays(Holidays $holidays)
    {
        $this->getFrom()->setHolidays($holidays);
        $this->getTo()->setHolidays($holidays);

        return $this;
    }

    public function humanize()
    {
        if ($this->getFrom()->getDays() == $this->getTo()->getDays()) {
            return $this->getFrom()->getDays().' business days';
        } else {
            return $this->getFrom()->getDays().' - '.$this->getTo()->getDays().' business days';
        }
    }
}

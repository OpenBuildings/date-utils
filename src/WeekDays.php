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
        $end = $this->getNewStartDate($start)->modify("+ {$this->getDays()} weekdays");

        return WeekDays::ensureWeekdays($end);
    }

    /**
     * @return string
     */
    public function humanize()
    {
        return "{$this->getDays()} week days";
    }

    /**
     * Workaround for PHP 5.4 bug https://bugs.php.net/bug.php?id=63521
     * Ensure weekdays are correctly used despite the bug in PHP 5.4
     * which might result in Sunday instead of Friday.
     *
     * @param  DateTime $date
     * @return DateTime
     */
    public static function ensureWeekdays(DateTime $date)
    {
        $weekDay = (int) $date->format('N');

        if (7 === $weekDay) {
            $date = $date->modify('-2 days');
        } elseif (6 === $weekDay) {
            $date = $date->modify('-1 day');
        }

        return $date;
    }
}

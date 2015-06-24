<?php

namespace CL\DateUtils;

use DateTime;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Days
{
    /**
     * @var integer
     */
    private $days;

    public function __construct($days)
    {
        $this->days = (int) $days;
    }

    /**
     * @return integer
     */
    public function getDays()
    {
        return $this->days;
    }

    public function add(Days $days)
    {
        $this->days = $this->days + $days->days;

        return $this;
    }

    /**
     * @param  DateTime|null $start
     * @return DateTime
     */
    public function toDateTime(DateTime $start = null)
    {
        if ($start === null) {
            $start = new DateTime('now');
        } else {
            $start = clone $start;
        }

        return $start->modify("+ {$this->days} days");
    }

    public function humanize()
    {
        return "{$this->days} days";
    }
}

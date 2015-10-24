<?php

namespace CL\DateUtils;

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

    /**
     * @return DateTime
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return DateTime
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param  DateTime $datetime
     * @return boolean
     */
    public function contains(DateTime $datetime)
    {
        return ($this->from < $datetime and $this->to > $datetime);
    }

    /**
     * @return string
     */
    public function humanize()
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
}

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
    private $from;
    private $to;

    public function __construct(DateTime $from, DateTime $to)
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

    public function contains(DateTime $datetime)
    {
        return ($this->from < $datetime and $this->to > $datetime);
    }

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
        } else {
            return $from->format('j M Y').' - '.$to->format('j M Y');
        }
    }
}

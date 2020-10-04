<?php

namespace App\Helpers;

use Carbon\Carbon;

use App\Models\Timetable;

use DatePeriod;
use DateInterval;
/**
 * Class ViewFormatter
 * @package App\Helpers
 * @version Jun 23, 2017, 11:09 pm UTC
 */

class DatetimeHelper
{
    public static function createRange($date_from, $date_until) {
        //fechas entre $from y $until
        $daterange = new \DatePeriod(
            \DateTime::createFromFormat('Y-m-d', $date_from),
            new \DateInterval('P1D'),
            \DateTime::createFromFormat('Y-m-d', $date_until)->add(new DateInterval('P1D'))
        );

        return $daterange;
    }

    public static function getIndexOfDay($date) {
        
        $day = date('w', strtotime($date->format("l")));
        
        return $day == 0 ? 6 : $day-1;
    }

    public static function getDayOfWeek($date) {
        
        $days = Timetable::$days;

        return $days[self::getIndexOfDay($date)];
    }
}
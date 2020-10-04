<?php

namespace App\Helpers;

use App\Models\Timetable;

use App\Models\Professional;
/**
 * Class Timetableormatter
 * @package App\Helpers
 * @version Jun 23, 2017, 11:09 pm UTC
 */

class TimetableFormatter 
{
    //Create an array like array[id] => value
    public static function explodeHours(Timetable $timetable) {
        
        $timetable_array['opening_hour']   = explode(':', $timetable->from);
        $timetable_array['closing_hour']   = explode(':', $timetable->until);
        $timetable_array['delta_time']     = explode(':', $timetable->delta);
    
        return (Object) $timetable_array;
    }

    //Timetable to show
    public static function getDatetimeForView(Professional $professional){
        $timetables = $professional->timetables()->orderBy('day','asc')->orderBy('from','asc')->get();
        
        foreach($timetables as $timetable){
            $data[$timetable->day][] = $timetable->from.' a '.$timetable->until; 
        }

        $data = array();
        
        $data = array_map(function($el){return implode(' y ', $el);}, $data);
        
        return $data;
    }
    
}
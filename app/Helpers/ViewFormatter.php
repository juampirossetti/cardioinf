<?php

namespace App\Helpers;

use Carbon\Carbon;

/**
 * Class ViewFormatter
 * @package App\Helpers
 * @version Jun 23, 2017, 11:09 pm UTC
 */

class ViewFormatter 
{
    // Create time H:i from H:i:s 
    public static function createTimeHi($raw_time) {
        $time = Carbon::createFromFormat('H:i:s', $raw_time);
        return $time->format('H:i');
    }

    //Create an array like array[id] => value
    public static function getArrayForSelect($array, $key_name, $value_name1, $value_name2 = null) {
        $aux = array();
        foreach($array as $e) {
            $aux[$e->$key_name] = $e->$value_name1;
            if($value_name2 != null) {
                $aux[$e->$key_name] =$aux[$e->$key_name].' '.$e->$value_name2;
            }
        }
        return $aux;
    }
    
}

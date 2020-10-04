<?php

namespace App\Formatter;

use App\Helpers\ViewFormatter as Format;

use App\Models\Professional;

/**
 * Mutators and methods for blade
 *
 */
trait TimetableView
{
    
    public static $days = [
        '0' => 'Lunes', 
        '1' => 'Martes', 
        '2' => 'Miercoles', 
        '3' => 'Jueves', 
        '4' => 'Viernes', 
        '5' => 'Sabado', 
        '6' => 'Domingo'
    ];

    public static $turn = [
        '0' => 'Mañana', 
        '1' => 'Tarde'
    ];

    public function getDayAttribute($value) {
        return self::$days[$value];
    }

    public function getFromAttribute() {
        return Format::createTimeHi($this->attributes['from']);
    }

    public function getUntilAttribute() {
        return Format::createTimeHi($this->attributes['until']);
    }

    public function getDeltaAttribute() {
        return Format::createTimeHi($this->attributes['delta']);
    }
    
    public function getTurnAttribute($value) {
        return self::$turn[$value];
    }
    
    public function getDay() {
        return $this->attributes['day'];
    }

    public function getTurn() {
        return $this->attributes['turn'];
    }

    public function getProfessionalIdAttribute($value) {
        $professional = Professional::findOrFail($value);
        return $professional->getCompleteName();
    }

    public function getProfessionalId() {
        return $this->attributes['professional_id'];
    }

}
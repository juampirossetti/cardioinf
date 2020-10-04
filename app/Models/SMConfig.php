<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
use Log;
use DB;

class SMConfig extends Model
{   
    protected $table = 'sm_configs';
    
    protected $fillable = [
        "key", "value", "section"
    ];
    
    protected $hidden = [
        
    ];

    // SMConfig::getByKey('sitename');
    public static function getByKey($key) {
        $row = SMConfig::where('key',$key)->first();
        if(isset($row->value)) {
            return $row->value;
        } else {
            return false;
        }
    }
    
    // SMConfig::getAll();
    public static function getAll() {
        $configs = array();
        $configs_db = SMConfig::all();
        foreach ($configs_db as $row) {
            $configs[$row->key] = $row->value;
        }
        $configs['start_hours'] = explode(',',$configs['start_hours']);
        $configs['end_hours'] = explode(',',$configs['end_hours']);
        return (object) $configs;
    }
}
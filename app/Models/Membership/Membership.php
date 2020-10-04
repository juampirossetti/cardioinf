<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{   
    protected $table = 'site_membership';

    protected $fillable = [
        "name"
    ];
}
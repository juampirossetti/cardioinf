<?php

namespace App\Repositories;

use App\Models\TempReservation;

use InfyOm\Generator\Common\BaseRepository;

class TempReservationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TempReservation::class;
    }
}
<?php

namespace App\Repositories;

use App\Models\Auditoria;

use InfyOm\Generator\Common\BaseRepository;

class AuditoriaRepository extends BaseRepository
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
        return Auditoria::class;
    }
}
<?php

namespace App\Repositories;

use App\Models\Card;

use InfyOm\Generator\Common\BaseRepository;

class CardRepository extends BaseRepository
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
        return Card::class;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Nullable fields
     *
     * @var array
     */
    protected $nullable = [];

    /**
     * Set empty nullable fields to null
     *
     * @param object $model
     */
    protected static function setNullables($model)
    {
        foreach ($model->nullable as $field) {
            if (empty($model->$field) && $model->$field !== '0') {
                $model->$field = null;
            } else {
                if ($model->$field == 'Libre') {
                    $model->$field = null;
                }
            }
        }
    }

    /**
     * Convert the model instance to an array.
     * 
     * @param bool $raw If set to true, mutate attributes and add appends.
     * @return array
     */
    public function toArray($raw = false)
    {
        return $raw ? $this->getArrayableAttributes() : parent::toArray();
    }
}

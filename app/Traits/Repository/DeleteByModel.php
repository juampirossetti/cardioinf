<?php 

namespace App\Traits\Repository;

/**
 * This trait add function to delete by model in a repository,
 *
 */

trait DeleteByModel
{
    /**
    * Set the keys for a save update query.
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    
    public function deleteByModel($model) {
        $model->delete();    
    }
}
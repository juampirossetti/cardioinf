<?php

namespace App\DataTables;

use App\Models\Professional;
use Form;
use Yajra\Datatables\Services\DataTable;

abstract class DataTableFilter extends DataTable
{
    protected $filterAttributes;

    public function customFilter($query)
    {
        foreach($this->filterAttributes as $filter_name => $operator){
            $value = isset($this->attributes[$filter_name]) ? $this->attributes[$filter_name] : null;
            if($value != null){
                switch ($operator) {
                    case 'LIKE':
                        $query->where($filter_name,'LIKE','%'.$value.'%');
                        break;
                    default:
                        $query->where($filter_name, $operator , $value);
                        break;
                }
            }
        }
        return $query;
    }
}
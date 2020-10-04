<?php

namespace App\DataTables;

use App\Models\PatientInsurance;
use Form;
use Yajra\Datatables\Services\DataTable;

class PatientInsuranceDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'patients.insurances.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $patient_insurances = PatientInsurance::query();

        $patient_id = $this->attributes['patient_id'];
        
        if($patient_id != null){
            $patient_insurances->where('patient_id',$patient_id);
        }
        
        return $this->applyScopes($patient_insurances);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%', 'title' => 'Acción'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'bFilter' => false,
                'pageLength' => 20,
                'responsive' => true,
                'buttons' => [
                    // 'print',
                    // 'reset',
                    // 'reload',
                    // [
                    //      'extend'  => 'collection',
                    //      'text'    => '<i class="fa fa-download"></i> Export',
                    //      'buttons' => [
                    //          // 'csv',
                    //          'excel',
                    //          // 'pdf',
                    //      ],
                    // ],
                    // 'colvis'
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'id' => ['name' => 'id', 'data' => 'id','visible' => false],
            'Obra_social' => ['name' => 'insurance_name', 'data' => 'insurance_name','searchable' => 'false', 'orderable' => 'false'],
            'plan' => ['name' => 'plan', 'data' => 'plan', 'searchable' => 'false', 'orderable' => 'false', 'class' => 'desktop'],
            'number' => ['name' => 'number', 'data' => 'number','searchable' => 'false', 'orderable' => 'false', 'class' => 'desktop']

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'patient_insurances';
    }
}
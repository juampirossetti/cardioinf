<?php

namespace App\DataTables;

use App\Models\History;
use Form;
use Yajra\Datatables\Services\DataTable;

class PatientHistoryDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('patient_name', function(History $history) {
                    return ucfirst(strtolower($history->patient_name));
                })
            ->editColumn('patient_surname', function(History $history) {
                    return ucfirst(strtolower($history->patient_surname));
                })
            ->addColumn('action', 'patients_histories.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        //$histories = History::query();
        $histories = History::orderBy('patient_surname', 'ASC');

        $professional_id = $this->attributes['professional_id'];
        
        if($professional_id != null){
            $histories->where('professional_id',$professional_id);
        }

        return $this->applyScopes($histories);
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
            ->addAction(['width' => '10%', 'title' => 'Acción', 'class' => 'col-md-2'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'pageLength' => '40',
                'buttons' => [
                    // 'print',
                    // 'reset',
                    // 'reload',
                    // [
                    //      'extend'  => 'collection',
                    //      'text'    => '<i class="fa fa-download"></i> Exportar',
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
            'id' => ['name' => 'id', 'data' => 'id', 'visible' => false, 'searchable' => 'false'],
            'apellido' => ['name' => 'patient_surname', 'data' => 'patient_surname', 'class' => 'col-md-4'],
            'nombre' => ['name' => 'patient_name', 'data' => 'patient_name', 'class' => 'col-md-3'],
            'documento' => ['name' => 'dni', 'data' => 'dni', 'class' => 'col-md-3'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'histories';
    }
}

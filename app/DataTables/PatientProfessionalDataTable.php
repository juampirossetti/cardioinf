<?php

namespace App\DataTables;

use App\Models\Professional;
use Form;
use Yajra\Datatables\Services\DataTable;

class PatientProfessionalDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'patient_section.professionals.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $professionals = Professional::query();

        $role = $this->attributes['role'];

        if($role == 'patient'){
            $professionals->where('patient_enabled',true);
        }

        return $this->applyScopes($professionals);
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
                'pageLength' => 50,
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
            'apellido' => ['name' => 'surname', 'data' => 'surname', 'visible' => false],
            'nombre' => ['name' => 'complete_name', 'data' => 'complete_name'],
            'Especialidad' => ['name' => 'speciality', 'data' => 'speciality']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'medicos';
    }
}

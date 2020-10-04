<?php

namespace App\DataTables;

use App\Models\Professional;
use Form;
use Yajra\Datatables\Services\DataTable;

use App\DataTables\DataTableFilter;

class ProfessionalDataTable extends DataTableFilter
{

    /* [Name of the attribute => comparison operator] */
    protected $filterAttributes = [
        'name' =>'LIKE',
        'surname' =>'LIKE'
    ];
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'professionals.datatables_actions')
            ->editColumn('patient_enabled', function($professional) {
                return $professional->patient_enabled ? 'Si' : 'No';
            })
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

        $professionals = $this->customFilter($professionals);

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
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Exportar',
                         'buttons' => [
                             // 'csv',
                             'excel',
                             // 'pdf',
                         ],
                    ],
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
            'apellido' => ['name' => 'surname', 'data' => 'surname'],
            'nombre' => ['name' => 'name', 'data' => 'name'],
            'habilitado_a_paciente' => ['name' => 'patient_enabled', 'data' => 'patient_enabled']
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

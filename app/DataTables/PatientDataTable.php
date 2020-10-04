<?php

namespace App\DataTables;

use App\Models\Patient;
use Form;
use Yajra\Datatables\Services\DataTable;

use App\DataTables\DataTableFilter;

class PatientDataTable extends DataTableFilter
{

    /* [Name of the attribute => comparison operator] */
    protected $filterAttributes = [
        'name' =>'LIKE',
        'surname' =>'LIKE',
        'dni' => 'LIKE'
    ];

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'patients.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $patients = Patient::query();

        $patients = $this->customFilter($patients);

        return $this->applyScopes($patients);
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
                'responsive' => true,
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
            'dni' => ['name' => 'dni', 'data' => 'dni', 'class' => 'desktop'],
            'obra_social' => ['name' => 'insurance_name', 'data' => 'insurance_name', 'searchable' => 'false', 'orderable' => 'false', 'class' => 'desktop'],
            'teléfono' => ['name' => 'primary_phone', 'data' => 'primary_phone', 'searchable' => 'false','orderable' => 'false', 'class' => 'desktop'],
            'email' => ['name' => 'email', 'data' => 'email', 'visible' => false, 'searchable' => 'false']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pacientes';
    }
}

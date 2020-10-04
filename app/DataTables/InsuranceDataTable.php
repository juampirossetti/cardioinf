<?php

namespace App\DataTables;

use App\Models\Insurance;
use Form;
use Yajra\Datatables\Services\DataTable;

use App\DataTables\DataTableFilter;

class InsuranceDataTable extends DataTableFilter
{
    /* [Name of the attribute => comparison operator] */
    protected $filterAttributes = [
        'name' =>'LIKE'
    ];
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'insurances.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $insurances = Insurance::query();

        $insurances = $this->customFilter($insurances);

        return $this->applyScopes($insurances);
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
            'nombre' => ['name' => 'name', 'data' => 'name'],
            'nombre_corto' => ['name' => 'short_name', 'data' => 'short_name', 'class' => 'desktop'],
            'habilitada' => ['name' => 'enabled', 'data' => 'enabled', 'searchable' => 'false', 'orderable' => 'false'],
            'habilitada_pacientes' => ['name' => 'is_patient_enabled', 'data' => 'is_patient_enabled', 'searchable' => 'false', 'orderable' => 'false', 'class' => 'desktop']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'obras_sociales';
    }
}

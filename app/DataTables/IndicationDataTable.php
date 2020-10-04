<?php

namespace App\DataTables;

use App\Models\Indication;

use Form;

use Yajra\Datatables\Services\DataTable;

use App\DataTables\DataTableFilter;

class IndicationDataTable extends DataTableFilter
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
            ->addColumn('action', 'indications.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $indications = Indication::query();

        $indications = $this->customFilter($indications);

        return $this->applyScopes($indications);
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
            'id' => ['name' => 'id', 'data' => 'id','visible' => false],
            'obra_social' => ['name' => 'insurance_name', 'data' => 'insurance_name','searchable' => 'false', 'orderable' => 'false'],
            'estudio_medico' => ['name' => 'medical_study_name', 'data' => 'medical_study_name','searchable' => 'false', 'orderable' => 'false'],
            'habilitada_para_turno' => ['name' => 'enabled_appointment_text', 'data' => 'enabled_appointment_text','searchable' => 'false', 'orderable' => 'false'],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'indicaciones';
    }
}

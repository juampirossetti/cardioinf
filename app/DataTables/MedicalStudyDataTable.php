<?php

namespace App\DataTables;

use App\Models\MedicalStudy;
use Form;
use Yajra\Datatables\Services\DataTable;

use App\DataTables\DataTableFilter;

class MedicalStudyDataTable extends DataTableFilter
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
            ->addColumn('action', 'medical_studies.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $medicalStudies = MedicalStudy::query();

        $medicalStudies = $this->customFilter($medicalStudies);

        return $this->applyScopes($medicalStudies);
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
            ->addAction(['width' => '10%','title' => 'Acción'])
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
                             'excel',
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
            'Nombre' => ['name' => 'name', 'data' => 'name'],
            'Acrónimo' => ['name' => 'acronym', 'data' => 'acronym', 'class' => 'desktop'],
            'Habilitado Secretaria' => ['name' => 'is_enabled', 'data' => 'is_enabled', 'searchable' => 'false', 'orderable' => 'false'],
            'Habilitado Paciente' => ['name' => 'is_patient_enabled', 'data' => 'is_patient_enabled', 'searchable' => 'false', 'orderable' => 'false', 'class' => 'desktop']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'medicalStudies';
    }
}

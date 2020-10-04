<?php

namespace App\DataTables;

use App\Models\ProfessionalInsurance;
use Form;
use Yajra\Datatables\Services\DataTable;

class ProfessionalInsuranceDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'professionals.insurances.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $professional_insurances = ProfessionalInsurance::query();

        $professional_id = $this->attributes['professional_id'];
        
        if($professional_id != null){
            $professional_insurances->where('professional_id',$professional_id);
        }
        
        return $this->applyScopes($professional_insurances);
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
            'mostrar_a_paciente' => ['name' => 'enabled_patient_text', 'data' => 'enabled_patient_text','searchable' => 'false', 'orderable' => 'false'],
            'mensaje_a_paciente' => ['name' => 'have_message', 'data' => 'have_message','searchable' => 'false', 'orderable' => 'false'],
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
        return 'profesional_insurances';
    }
}
<?php

namespace App\DataTables;

use App\Models\Appointment;
use Form;
use Yajra\Datatables\Services\DataTable;

class AppointmentsListDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('patient_id', function(Appointment $app) {
                    return $app->getOwnernameAttribute();
                })
            ->orderColumns(['patient_id', 'professional_name'], '-:column $1')
//            ->addColumn('action', 'appointments_list.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $appointments = Appointment::query()->where('status','=',1);

        return $this->applyScopes($appointments);
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
            //->addAction(['width' => '10%'])
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
                    /*
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
                         'buttons' => [
                             // 'csv',
                             'excel',
                             // 'pdf',
                         ],
                    ],
                    */
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
            'id' => ['name' => 'id', 'data' => 'id', 'visible' => false],
            'paciente' => ['name' => 'patient_id', 'data' => 'patient_id'],
            'médico' => ['name' => 'professional_name', 'data' => 'professional_name', 'searchable' => false],
            'fecha' => ['name' => 'date', 'data' => 'date'],
            'hora' => ['name' => 'time', 'data' => 'time'],
            'estado' => ['name' => 'status', 'data' => 'status']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'appointments';
    }
}

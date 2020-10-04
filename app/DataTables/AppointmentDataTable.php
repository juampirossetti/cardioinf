<?php

namespace App\DataTables;

use App\Models\Appointment;
use Form;
use Yajra\Datatables\Services\DataTable;

class AppointmentDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'appointments.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $appointments = Appointment::query();

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
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'pageLength' => 50,
                'buttons' => [
                    // 'print',
                    // 'reset',
                    // 'reload',
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
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
            'médico' => ['name' => 'professional_id', 'data' => 'professional_id'],
            'fecha' => ['name' => 'date', 'data' => 'date'],
            'hora' => ['name' => 'time', 'data' => 'time'],
            'estado' => ['name' => 'status', 'data' => 'status'],
            'paciente' => ['name' => 'patient_id', 'data' => 'patient_id'],
            'depósito' => ['name' => 'money', 'data' => 'money'],
            'cupones' => ['name' => 'coupons', 'data' => 'coupons']
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

<?php

namespace App\DataTables\Patient;

use App\Models\Appointment;
use Form;
use Yajra\Datatables\Services\DataTable;

use Carbon\Carbon;

class PatientAppointmentDataTable extends DataTable
{
    //public $professionals = array();
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'patient_section.appointments.datatables_actions')
            ->editColumn('date', function($row) {
                $date = explode(' ', Carbon::createFromFormat('Y-m-d', $row->date)->formatLocalized('%d de %B de %Y'));
                $date[2] = ucfirst($date[2]);
                return implode(' ', $date);
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
        $appointments = Appointment::query();
        
        $patient_id = $this->attributes['patient_id'];
        $user_id = $this->attributes['user_id'];

        if($patient_id != null){
            $appointments->where('patient_id',$patient_id)->orWhere('user_id', $user_id);
        }
        

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
            ->addAction(['width' => '10%', 'title' => 'Gestión'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'bFilter' => false,
                'scrollX' => false,
                'order' => [[2, 'desc'], [3, 'desc']],
                'buttons' => [],
                'responsive' => true,
                'rowReorder' => ['selector' => 'td:nth-child(2)']
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
            'médico' => ['name' => 'professional_name', 'data' => 'professional_name'],
            'paciente' => ['name' => 'ownername', 'data' => 'ownername', 'searchable' => false, 'orderable' => false, 'class' => 'desktop'],
            'fecha' => ['name' => 'date', 'data' => 'date'],
            'hora' => ['name' => 'time', 'data' => 'time', 'class' => 'desktop'],
            'tipo_de_consulta' => ['name' => 'medical_study_name', 'data' => 'medical_study_name', 'class' => 'desktop'],
            'obra_social' => ['name' => 'insurance_name', 'data' => 'insurance_name', 'class' => 'desktop']
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
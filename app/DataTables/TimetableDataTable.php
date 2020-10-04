<?php

namespace App\DataTables;

use App\Models\Timetable;
use Form;
use Yajra\Datatables\Services\DataTable;

class TimetableDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'timetables.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $timetables = Timetable::query();

        return $this->applyScopes($timetables);
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
                'pageLength' => 30,
                'drawCallback' => 'function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:"current"} ).nodes();
                    var last=null;
 
                    api.column(0, {page:"current"} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before("<tr class=\'group\'><td colspan=\'6\'>"+group+"</td></tr>");
                            last = group;
                        }
                    });
                }',
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
            'médico' => ['name' => 'professional_id', 'data' => 'professional_id', 'visible' => false],
            'día' => ['name' => 'day', 'data' => 'day', 'searchable' => 'false'],
            'turno' => ['name' => 'turn', 'data' => 'turn', 'searchable' => 'false', 'orderable' => 'false'],
            'desde' => ['name' => 'from', 'data' => 'from', 'searchable' => 'false', 'orderable' => 'false', 'class' => 'desktop'],
            'hasta' => ['name' => 'until', 'data' => 'until', 'searchable' => 'false', 'orderable' => 'false', 'class' => 'desktop'],
            'minutos_entre_turnos' => ['name' => 'delta', 'data' => 'delta', 'searchable' => 'false', 'orderable' => 'false', 'class' => 'desktop']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'horarios';
    }
}

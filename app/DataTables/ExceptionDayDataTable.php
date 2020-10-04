<?php

namespace App\DataTables;

use App\Models\ExceptionDay;
use Form;
use Yajra\Datatables\Services\DataTable;

use App\DataTables\DataTableFilter;

use Carbon\Carbon;

class ExceptionDayDataTable extends DataTableFilter
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
            ->addColumn('action', 'exceptions_days.datatables_actions')
            ->editColumn('date', function ($exceptionDay) {
                return $exceptionDay->date ? with(new Carbon($exceptionDay->date))->format('d-m-Y') : '';
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
        $exceptionsDays = ExceptionDay::query();

        $exceptionsDays = $this->customFilter($exceptionsDays);

        return $this->applyScopes($exceptionsDays);
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
                'order' => [[1, 'desc']],
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
            'Id' => ['name' => 'id', 'data' => 'id', 'visible' => false ],
            'Fecha' => ['name' => 'date', 'data' => 'date', 'class' => 'col-sm-2'],
            'Médico' => ['name' => 'professional_name', 'data' => 'professional_name', 'class' => 'col-sm-4'],
            'Estudios' => ['name' => 'display_ms', 'data' => 'display_ms', 'class' => 'col-sm-6'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'excepciones';
    }
}

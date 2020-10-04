<?php

namespace App\DataTables;

use App\Models\RoleUser;
use Form;
use Yajra\Datatables\Services\DataTable;

class RoleUserDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'role_users.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $roleUsers = RoleUser::query();

        //dd($roleUsers);

        return $this->applyScopes($roleUsers);
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
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
                         'buttons' => [
                             // 'csv',
                             'excel',
                             // 'pdf',
                         ],
                    ],
                    'colvis'
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
            'usuario_id' => ['name' => 'user_id', 'data' => 'user_id', 'visible' => false],
            'usuario' => ['name' => 'user_name', 'data' => 'user_name'],
            'email' => ['name' => 'email', 'data' => 'email'],
            'rol' => ['name' => 'role_name', 'data' => 'role_name'],
            'fecha_creación' => ['name' => 'created_at', 'data' => 'created_at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'roleUsers';
    }
}

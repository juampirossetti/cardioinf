<?php

namespace App\DataTables;

use App\Models\Mail;
use Form;
use Yajra\Datatables\Services\DataTable;

use Carbon\Carbon;

class MailboxDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'mailbox.datatables_actions')
            ->editColumn('sended_date', function(Mail $email) {
                    return Carbon::parse($email->sended_date)->format('d-m-Y H:i');
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
        $mails = Mail::orderBy('sended_date','DESC');

        $user_id = $this->attributes['user_id'];
        
        if($user_id != null){
            $mails->where('user_id',$user_id);
        }

        return $this->applyScopes($mails);
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
            ->addAction(['width' => '10%', 'title' => 'Ver/Borrar'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'bFilter' => false,
                'buttons' => [
                    [
                    ],
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
            'Para' => ['name' => 'to', 'data' => 'to'],
            'Asunto' => ['name' => 'subject', 'data' => 'subject'],
            'Fecha' => ['name' => 'sended_date', 'data' => 'sended_date']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'emails';
    }
}

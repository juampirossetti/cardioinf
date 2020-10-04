<?php

namespace App\Http\Controllers;

use App\DataTables\AppointmentsListDataTable;

use App\Http\Controllers\AppBaseController;

use Auth;

class AppointmentsListController extends AppBaseController
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the Appointment.
     *
     * @param AppointmentDataTable $appointmentDataTable
     * @return Response
     */
/*    public function index(AppointmentsListDataTable $appointmentsListDataTable)
    {
        return $appointmentsListDataTable->render('appointments_list.index');
    }
*/
    public function index()
    {
        $user = Auth::user();

        return view('appointments_list.index')
            ->with('user', $user);
    }

}

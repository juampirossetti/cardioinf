<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/* ================== Patient ================== */
Route::group(['middleware' => ['auth:api', 'role:patient']],function () {
    
    Route::post('/patients/appointments', 'ApiAppointmentController@listAppointments')->name('appointments.list');
   
    Route::post('/reservations', 'ApiReservationController@reserve')->name('reservation.reserve');
   
    //Route::post('/patients/professionals/{professional_id}/insurances/{insurance_id}', 'ApiInsuranceExceptionController@show')->name('insuranceException.show');

    Route::post('/patients/indications', 'ApiIndicationController@show')->name('indications.show');

    Route::get('/appointments/disponibility', 'ApiAppointmentController@disponibility')->name('appointments.disponibility');

    Route::get('/insurances/getAvailables', 'ApiInsuranceController@getAvailablesFromMedicalStudy')->name('insurances.availablesForMS');
});

/* ================== Secretary ================== */
Route::group(['middleware' => ['auth:api', 'role:secretary|admin','membership:basic']],function () {
    
    Route::post('/patients', 'ApiPatientController@store')->name('patients.show');
    
    Route::get('/patients/advanced', 'ApiPatientController@advancedSearch')->name('patients.searchAdvanced');
    
    Route::get('/patients/{id}', 'ApiPatientController@show')->name('patients.show');
    
    Route::post('/appointments', 'ApiAppointmentController@store')->name('appointments.store');
    
    Route::post('/calendar/bulk', 'ApiCalendarController@bulkStore')->name('calendar.bulkstore');

    Route::post('/calendar/bulkAction', 'ApiCalendarController@bulkAction')->name('calendar.bulkAction');

    Route::post('/patients/appointmentsSearch', 'ApiAppointmentController@search')->name('appointments.search');

    Route::get('/patients/dni/{dni}', 'ApiPatientController@showByDni')->name('patients.showByDni');

    Route::delete('/appointments/{id}', 'ApiAppointmentController@destroy')->name('appointments.delete');

    Route::post('/user/generatePassword', 'ApiUserController@generatePassword')->name('user.generatePassword');

    Route::post('/user/generateProfessionalPassword', 'ApiUserController@generateProfessionalPassword')->name('user.generateProfessionalPassword');
    
    Route::get('appointment/{id}', 'ApiAppointmentController@show')->name('appointment.show');
    
    Route::post('appointment/{id}/reserve', 'ApiReservationController@reservation')->name('appointment.reserve');

});


/* ================== Secretary ================== */
Route::group(['middleware' => ['auth:api', 'role:professional|secretary','membership:basic']],function () {

    Route::put('/appointments/{id}', 'ApiAppointmentController@update')->name('appointments.update');

    Route::get('/config/calendar/minMaxTime', 'ApiConfigCalendarController@minMaxTime')->name('config.calendar.minmax');
    
    Route::post('/calendar/appointments', 'ApiCalendarController@listAppointments')->name('calendar.list');

    Route::get('/appointments/disponibilityExtended', 'ApiAppointmentController@disponibilityExtended')->name('appointments.disponibility');

    Route::get('/users/patients', 'ApiUserController@patients')->name('users.patients');    

    Route::get('/appointments/patients', 'ApiAppointmentController@patients')->name('appointments.patients');    

    Route::get('/insurances/availables', 'ApiInsuranceController@availables')->name('insurances.availables');

    Route::delete('/detail/{id}', 'ApiHistoryDetailController@destroy')->name('historyDetail.delete');

    Route::put('/detail/{id}', 'ApiHistoryDetailController@update')->name('historyDetail.update');

    Route::delete('/file/{id}', 'ApiHistoryFileController@destroy')->name('historyFile.delete');
});
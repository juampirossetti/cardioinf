<?php

/* ================== Patient ================== */
Route::group(['prefix' => 'patient', 'middleware' => ['auth', 'role:patient']],function () {
    Route::get('/', 'HomeController@index');

    Route::get('professionals', 'Patient\PatientProfessionalController@index')->name('patient.professionals.index');

    Route::get('appointments', 'Patient\PatientAppointmentController@index')->name('patient.appointments.index');

    Route::get('appointments/create', 'Patient\PatientAppointmentController@create')->name('patient.appointments.create');

    Route::delete('appointments/{id}', 'Patient\PatientAppointmentController@destroy')->name('patient.appointments.destroy');

    Route::post('appointments', 'Patient\PatientAppointmentController@update')->name('patient.appointments.store');

    Route::get('profile', 'Patient\PatientProfileController@show')->name('patient.profile');

    Route::post('profile', 'Patient\PatientProfileController@update')->name('patient.profile.update');

    Route::get('/voucher/{appointment}/print', 'API\ApiVoucherController@printVoucher')->name('voucher.print');

    //Route::post('profile', ['as' => 'patients.cards.data', 'uses' => 'CardController@cardsData']);
});
<?php
/* ================== Secretary & Professional ================== */
Route::group(['middleware' => ['auth', 'role:secretary|admin|professional', 'membership:basic']],function () {

    Route::group(['prefix' => 'management'], function(){

        Route::resource('patients', 'PatientController');

        Route::resource('historias', 'PatientHistoryController');

        Route::resource('detalleHistoria', 'DetailHistoryController');
        Route::post('detalleHistoria/update', 'DetailHistoryController@update')->name('detalleHistoria.update');
    
        Route::resource('patients/{patient}/insurances', 'PatientInsuranceController', 
        [
            'only'   => ['edit', 'update', 'destroy', 'create', 'store'],
            'names'  => ['edit'    => 'patients.insurances.edit',
                         'update'  => 'patients.insurances.update',
                         'destroy' => 'patients.insurances.destroy',
                         'create'  => 'patients.insurances.create',
                         'store'   => 'patients.insurances.store']
        ]);

        Route::get('datatables/patients/cards', ['as' => 'patients.cards.data', 'uses' => 'CardController@cardsData']);

        Route::resource('patients/{patient}/cards', 'CardController', 
        [
            'only'   => ['edit', 'update', 'destroy', 'create', 'store'],
            'names'  => ['edit'    => 'patients.cards.edit',
                         'update'  => 'patients.cards.update',
                         'destroy' => 'patients.cards.destroy',
                         'create'  => 'patients.cards.create',
                         'store'   => 'patients.cards.store']
        ]);

        Route::resource('mailbox', 'MailboxController', ['only'   => ['index','create','show','destroy']]);
        
        Route::post('mailbox/sendemail', ['as' => 'mailbox.sendemail', 'uses' => 'MailboxController@sendEmail']);
    
    });

});



/* ================== Secretary ================== */
Route::group(['middleware' => ['auth', 'role:secretary|admin', 'membership:basic']],function () {

    Route::group(['prefix' => 'secretary'], function(){

        Route::get('/', function () {
            return redirect('secretary/professionals');
        });

        Route::resource('appointmentslist', 'AppointmentsListController');

        Route::resource('histories', 'HistoryController');

        Route::resource('historyDetails', 'HistoryDetailController');

        Route::resource('calendar', 'CalendarController', 
            ['only' => ['index','store']]);


        Route::group(['prefix' => 'configuration'], function () {
        
            Route::resource('professionals', 'ProfessionalController');

            Route::resource('insurances', 'InsuranceController');

            Route::resource('indications', 'IndicationController');

            Route::resource('medicalStudies', 'MedicalStudyController');

            Route::resource('exceptionsdays', 'ExceptionDayController');

            Route::resource('timetables', 'TimetableController');

            Route::resource('professionals/{professional}/insurances', 'ProfessionalInsuranceController', 
                [
                    'only'   => ['edit', 'update', 'destroy'],
                    'names'  => ['edit'    => 'professionals.insurances.edit',
                                 'update'  => 'professionals.insurances.update',
                                 'destroy' => 'professionals.insurances.destroy']
                ]);

            Route::get('system', 'SystemConfigurationController@index')->name('system.index');
        
            Route::post('system/{section?}', 'SystemConfigurationController@update')->name('system.update');

        });
    });
});
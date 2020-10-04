<?php

/* ================== Professional ================== */
Route::group(['middleware' => ['auth', 'role:professional']],function () {
    
    Route::get('/image/show/{history_id}/{image_id}','ImageController@showImage');

    Route::get('/image/download/{history_id}/{image_id}/{name?}','ImageController@showImage');

    Route::group(['prefix' => 'professional'], function(){

        // Route::get('/', 'HomeController@index');
    
        // Route::get('dashboard', 'Professional\DashboardController@index')->name('professional.dashboard');

        Route::get('calendar', 'Professional\ProfessionalCalendarController@index')->name('professional.calendar');
    
    });
});
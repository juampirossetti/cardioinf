<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::group(['middleware' => ['auth', 'role:secretary|admin']],function () {
    Route::post('/resetPasswordEmail/{id}', 'UserController@resetPasswordEmail')->name('users.passwordReset');
});

Route::group(['middleware' => ['auth', 'role:secretary|admin|patient|professional']],function () {
    
    Route::get('/account', 'AccountController@show')->name('account.show');
    
    Route::post('/account', 'AccountController@update')->name('account.update');
    
    Route::get('/support', 'SupportController@index')->name('support.index');
});

require __DIR__.'/patient_routes.php';

require __DIR__.'/secretary_routes.php';

require __DIR__.'/admin_routes.php';

require __DIR__.'/professional_routes.php';

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
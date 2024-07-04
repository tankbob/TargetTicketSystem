<?php

if (in_array(env('APP_ENV'), ['dev', 'production'])) {
    URL::forceSchema('https');
}

// Remove Registration
Route::any('auth/register', function () {
    return abort(404);
});

// Auth controllers
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

// Javascript Validation
Route::get('/js/validation.js', 'AppController@js');

// Images
Route::get('img/{path}', 'AppController@glide')->where('path', '.+');

// Failsafe redirect
Route::any('home', function () {
    return redirect('/');
});

/*
|
| Authenticated Users
|
*/

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'AppController@index');
    Route::get('dashboard/maintenance', 'AppController@showMaintenance');

    // Api
    Route::post('api/ticketsort', 'TicketController@setOrder');
    Route::post('api/getclientinfo', 'UserController@getInfo');
    Route::get('api/move/ticket/{direction}/{user_id}/{ticket_id}/{archived}', 'TicketController@move');

    // Backend
    Route::get('maintenance', 'AppController@showMaintenance');
    Route::resource('clients', 'ClientsController');
    Route::resource('adverts', 'AdvertController');
    Route::resource('services', 'ServicesController');

    Route::get('documents/{type}', 'AdminDocumentsController@index');
    Route::get('documents/{type}/create', 'AdminDocumentsController@create');
    Route::post('documents/{type}', 'AdminDocumentsController@store');
    Route::get('documents/{type}/{id}', 'AdminDocumentsController@show');
    Route::delete('documents/{type}/{id}', 'AdminDocumentsController@destroy');

    // Frontend
    Route::group(['middleware' => 'ownCompany'], function () {
        Route::resource('{company_slug}/tickets', 'TicketController');
        Route::get('{company_slug}/tickets/{id}/archive/{archive}', 'TicketController@archive');
        Route::get('{company_slug}/tickets/{id}/respond/{value}', 'TicketController@respond');
        Route::post('{company_slug}/tickets/{id}/addresponse', 'TicketController@addResponse');
        Route::post('{company_slug}/tickets/{ticket_id}/{response_id}/edittime', 'TicketController@editResponseTime');
        Route::get('{company_slug}/documents/{type}', 'DocumentsController@index');
    });
});

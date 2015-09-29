<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/', 'AppController@index');

// Failsafe redirect
Route::any('home', function () {
    return redirect('/');
});

Route::resource('/tickets', 'TicketController');
Route::get('/tickets/{id}/archive', 'TicketController@archive');
Route::get('/tickets/{id}/unarchive', 'TicketController@unarchive');
Route::get('ticketsuccess', 'TicketController@success');

Route::resource('/documents/{type}', 'DocumentsController');

Route::post('/api/ticketsort', 'TicketController@setOrder');
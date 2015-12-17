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

Route::get('dashboard/maintenance', 'AppController@showMaintenance');

// Backend
Route::resource('clients', 'ClientsController');
Route::resource('banners', 'AdvertController');
Route::resource('services', 'ServicesController');

Route::get('documents/{type}', 'AdminDocumentsController@index');
Route::get('documents/{type}/create', 'AdminDocumentsController@create');
Route::post('documents/{type}', 'AdminDocumentsController@store');
Route::get('documents/{type}/{id}', 'AdminDocumentsController@show');
Route::delete('documents/{type}/{id}', 'AdminDocumentsController@destroy');

// Frontend
Route::resource('{company_slug}/tickets', 'TicketController');
Route::get('{company_slug}/tickets/{id}/archive', 'TicketController@archive');
Route::get('{company_slug}/tickets/{id}/unarchive', 'TicketController@unarchive');
Route::post('{company_slug}/tickets/{id}/addresponse', 'TicketController@addResponse');
Route::post('{company_slug}/tickets/{ticket_id}/{response_id}/edittime', 'TicketController@editResponseTime');

Route::get('{company_slug}/documents/{type}', 'DocumentsController@index');

// Api
Route::post('api/ticketsort', 'TicketController@setOrder');
Route::post('api/getclientinfo', 'UserController@getInfo');

// Images
Route::get('img/{path}', function(Illuminate\Http\Request $request, $path) {
    // Image builder for glide
    $filesystem = config('filesystems.cloud');
    $client = Aws\S3\S3Client::factory([
        'credentials' => [
            'key'    => config('filesystems.disks.' . $filesystem . '.key'),
            'secret' => config('filesystems.disks.' . $filesystem . '.secret'),
        ],
        'region' => config('filesystems.disks.' . $filesystem . '.region'),
        'version' => 'latest',
    ]);
    $server = League\Glide\ServerFactory::create([
        'source' => new League\Flysystem\Filesystem(new League\Flysystem\AwsS3v3\AwsS3Adapter($client, config('filesystems.disks.' . $filesystem . '.bucket'))),
        'cache' => new League\Flysystem\Filesystem(new League\Flysystem\Adapter\Local(storage_path() . '/app')),
        'source_path_prefix' => '',
        'cache_path_prefix' => 'cache',
    ]);

	$server->outputImage($request->segment(2), $request->all());
})->where('path', '.+');

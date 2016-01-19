<?php

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('/', 'AppController@index');

Route::get('/js/validation.js', 'AppController@js');

// Failsafe redirect
Route::any('home', function () {
    return redirect('/');
});

Route::any('test/mail/html', function () {
    return view('emails.newTicket', ['response' => TargetInk\Response::first(), 'user' => auth()->user(), 'ticket' => TargetInk\Ticket::first()]);
});

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
Route::resource('{company_slug}/tickets', 'TicketController');
Route::get('{company_slug}/tickets/{id}/archive', 'TicketController@archive');
Route::get('{company_slug}/tickets/{id}/unarchive', 'TicketController@unarchive');
Route::post('{company_slug}/tickets/{id}/addresponse', 'TicketController@addResponse');
Route::post('{company_slug}/tickets/{ticket_id}/{response_id}/edittime', 'TicketController@editResponseTime');

Route::get('{company_slug}/documents/{type}', 'DocumentsController@index');

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

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
    Route::get('tasks', 'TasksController@index')->name('tasks');

});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '2',
        'redirect_uri' => 'http://oauthclient.dev:8080/auth/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://localhost:8000/oauth/authorize?'.$query);
});

Route::get('/auth/callback', function () {

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '2',
            'client_secret' => 'shxYoRL9xqEuvRFWR0xW8UWBocRbV8H6RY9huJch',
            'redirect_uri' => 'http://oauthclient.dev:8080/auth/callback',
            'code' => Request::input('code'),
        ],
    ]);

    $json = json_decode((string) $response->getBody(), true);

    $access_token = $json['access_token'];

    //TODO guardar tokens en persistència (base de dades)
    //SERVER: guardar a base de dades ok!
    //Client: app mòbil

    $response2 = $http->get('http://localhost:8000/api/v1/task', [
        'headers' => [
            'X-Requested-With' => 'XMLHttpRequest',
            'Authorization' => 'Bearer '.$access_token
        ],
    ]);

    $json2 = json_decode((string) $response2->getBody(), true);

    dd($json2);
});

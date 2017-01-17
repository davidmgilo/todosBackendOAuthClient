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
    Route::get('implicit', 'ImplicitController@index')->name('implicit');

    Route::get('tasks', 'TasksController@index')->name('tasks');

});

Route::get('/redirect', 'OauthController@redirect');

Route::get('/redirect_implicit', 'OauthController@redirect_implicit');

Route::get('/auth/callback','OauthController@callback');

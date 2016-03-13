<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        if(Auth::user())
            return redirect('/home');
        return view('welcome');
    });

    Route::get('/user/update','UserController@updateInfoPage');
    Route::post('/user/update','UserController@updateInfo');
    Route::get('/user/{id}','UserController@show');
    Route::get('/user/{id}/questions','UserController@show');
    Route::get('/user/{id}/answers','UserController@showProfileAnswers');

    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});

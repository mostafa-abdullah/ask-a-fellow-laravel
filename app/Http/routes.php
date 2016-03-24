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




    Route::get('/admin','AdminController@index');
    Route::get('/admin/add_course','AdminController@add_course_page');
    Route::get('/admin/add_major','AdminController@add_major_page');
    Route::post('/admin/add_major','AdminController@add_major');
    Route::post('/admin/add_course','AdminController@add_course');
    Route::get('/admin/delete_course/{id}','AdminController@delete_course');
    Route::get('/admin/delete_major/{id}','AdminController@delete_major');
    Route::get('/admin/update_course/{id}','AdminController@update_course_page');
    Route::get('/admin/update_major/{id}','AdminController@update_major_page');
    Route::post('/admin/update_course/{id}','AdminController@update_course');
    Route::post('/admin/update_major/{id}','AdminController@update_major');


    Route::get('/browse','AppController@browse');
    Route::get('/list_courses/{major}/{semester}','AjaxController@getCourses');
    Route::get('/browse/{course_id}','AppController@list_questions');
    Route::post('/browse/{course_id}','AppController@post_question');
    Route::get('/browse/{major}/{semester}','AppController@list_questions_all');
    Route::get('/answers/{question_id}','AppController@inside_question');
    Route::post('/answers/{question_id}','AppController@post_answer');
    Route::get('/delete_answer/{id}','AppController@delete_answer');
    Route::get('/delete_question/{id}','AppController@delete_question');




    Route::get('/vote/answer/{answer_id}/{type}','AjaxController@vote_answer');
    Route::get('/vote/question/{answer_id}/{type}','AjaxController@vote_question');


    Route::get('/notifications_partial/','AjaxController@view_notifications_partial');
    Route::get('/notifications/','AppController@view_notifications');
    Route::get('/mark_notification/{notification_id}/{read}','AjaxController@mark_notification');
    Route::get('/subscriptions','AppController@subscription_page');
    Route::post('/subscriptions','AppController@subscribe_to_courses');
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});

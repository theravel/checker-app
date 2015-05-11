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

Route::get('/', 'HomeController@getHome');
Route::get('home', 'HomeController@getHome');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'questions' => 'QuestionsController',
	// #19 temporary disable
	// 'password' => 'Auth\PasswordController',
]);

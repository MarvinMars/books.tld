<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('books','BookController@index');
//Route::get('users','UserController@index');
Route::get('books/{book}','BookController@show');
//Route::get('users/{user}','UserController@show');

Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResource('books', 'BookController')->only(['store','update', 'destroy']);
//    Route::apiResource('user', 'UserController')->only(['store','update', 'destroy']);
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

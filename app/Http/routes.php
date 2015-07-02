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

Route::controllers([
    'auth' => 'Auth\AuthController',
]);

Route::get('/', 'AppController@index');

Route::group(['prefix' => 'repositories'], function () {
    Route::get('/', 'RepositoryController@index');
    Route::get('{id}', 'RepositoryController@show')->where('id', '[0-9]+');
    Route::post('{id}/tags/add', 'RepositoryController@addTag')->where('id', '[0-9]+');
    Route::post('{id}/tags/remove', 'RepositoryController@removeTag')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('/', 'TagController@index');
    Route::get('{id}', 'TagController@show')->where('id', '[0-9]+');
});

Route::get('search/{keyword?}', 'SearchController@index');
Route::get('sync', 'SyncController@index');

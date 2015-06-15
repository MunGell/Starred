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

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');

Route::get('sync', 'SyncController@index');

Route::get('repositories', 'RepositoryController@index');
Route::post('repositories/{id}/tags/add', 'RepositoryController@addTag')->where('id', '[0-9]+');
Route::post('repositories/{id}/tags/remove', 'RepositoryController@removeTag')->where('id', '[0-9]+');
Route::get('repositories/{id}', 'RepositoryController@show')->where('id', '[0-9]+');

Route::get('tags', 'TagController@index');
Route::get('tags/{id}', 'TagController@show')->where('id', '[0-9]+');

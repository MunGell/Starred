<?php

Route::controllers([
    'auth' => 'Auth\AuthController',
]);

Route::get('/', 'AppController@index');

Route::group(['prefix' => 'repositories'], function () {
    Route::get('/', 'RepositoryController@index');
    Route::get('{id}', 'RepositoryController@show')->where('id', '[0-9]+');
    Route::post('{id}/tags/add', 'TagController@store')->where('id', '[0-9]+');
    Route::post('{id}/tags/remove', 'TagController@destroy')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('/', 'TagController@index');
    Route::get('{id}', 'TagController@show')->where('id', '[0-9]+');
});

Route::get('search/{keyword?}', 'SearchController@index');
Route::get('sync', 'SyncController@index');
Route::get('sync/queue', 'SyncController@checkQueue');

<?php

$router->controllers([
    'auth' => 'AuthController',
]);

$router->get('/', 'AppController@index');
$router->get('search/{keyword?}', 'SearchController@index');

$router->group([
    'middleware' => ['web'],
    'prefix' => 'repositories'
], function () use ($router) {
    $router->get('/', 'RepositoryController@index');
    $router->get('{id}', 'RepositoryController@show')->where('id', '[0-9]+');
    $router->post('{id}/tags/add', 'TagController@store')->where('id', '[0-9]+');
    $router->post('{id}/tags/remove', 'TagController@destroy')->where('id', '[0-9]+');
});

$router->group([
    'middleware' => ['web'],
    'prefix' => 'tags'
], function () use ($router) {
    $router->get('/', 'TagController@index');
    $router->get('{id}', 'TagController@show')->where('id', '[0-9]+');
});

$router->group([
    'middleware' => ['web'],
    'prefix' => 'sync'
], function () use ($router) {
    $router->get('/', 'SyncController@index');
    $router->get('sync/queue', 'SyncController@checkQueue');
});


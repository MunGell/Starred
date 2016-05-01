<?php

$router->group([
    'middleware' => ['web'],
    'prefix' => 'repositories'
], function () use ($router) {
    $router->get('/', 'RepositoryController@index');
    $router->get('{id}', 'RepositoryController@show')->where('id', '[0-9]+');
    $router->post('{id}/tags/add', 'TagController@store')->where('id', '[0-9]+');
    $router->post('{id}/tags/remove', 'TagController@destroy')->where('id', '[0-9]+');
});

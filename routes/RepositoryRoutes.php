<?php

$router->group([
    'middleware' => ['web', 'auth'],
    'prefix' => 'repositories'
], function () use ($router) {
    $router->get('/', 'RepositoryController@index');
    $router->get('{id}', 'RepositoryController@show')->where('id', '[0-9]+');
});

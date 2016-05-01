<?php

$router->group([
    'middleware' => ['web'],
    'prefix' => 'tags'
], function () use ($router) {
    $router->get('/', 'TagController@index');
    $router->get('{id}', 'TagController@show')->where('id', '[0-9]+');
});

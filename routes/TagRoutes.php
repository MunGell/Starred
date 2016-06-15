<?php

$router->group([
    'middleware' => ['web', 'auth']
], function () use ($router) {
    $router->get('tags', 'TagController@index');
    $router->post('tags', 'TagController@store');
    $router->delete('tags', 'TagController@destroy');
    $router->get('tags/{id}', 'TagController@show')->where('id', '[0-9]+');
});

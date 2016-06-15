<?php

$router->group([
    'middleware' => ['web']
], function () use ($router) {
    $router->get('/', 'AppController@index');
    $router->controllers(['auth' => 'AuthController']);

    $router->group([
        'middleware' => ['auth']
    ], function () use ($router) {
        $router->get('search/{keyword?}', 'SearchController@index');
    });
});

<?php

$router->group([
    'middleware' => ['web']
], function () use ($router) {
    $router->get('/', 'AppController@index');
    $router->get('search/{keyword?}', 'SearchController@index');
    $router->controllers(['auth' => 'AuthController']);
});

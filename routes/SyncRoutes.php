<?php

$router->group([
    'middleware' => ['web'],
    'prefix' => 'sync'
], function () use ($router) {
    $router->get('/', 'SyncController@index');
    $router->get('/queue', 'SyncController@checkQueue');
});

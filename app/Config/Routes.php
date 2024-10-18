<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->group('dashboard',['namespace'=>"App\Controllers\dashboard"], function ($routes) {
    $routes->resource('especies');
    $routes->resource('localidades');
    $routes->resource('logros');
});
$routes->group('user',['namespace'=>"App\Controllers\user"], function ($routes) {
    $routes->post('zonasPesca/get_localidades','ZonasPesca::getLocalidades');
    $routes->get('capturas/get_especies', 'Capturas::get_especies');
    $routes->resource('zonasPesca');
    $routes->resource('capturas');
    $routes->resource('competiciones');
    $routes->resource('participantes');

});

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
    $routes->post('competiciones/get_zonasPesca','Competiciones::get_zonasPesca');
    $routes->get('capturas/get_especies', 'Capturas::get_especies');
    $routes->get('participantes/(:num)','Competiciones::verParticipantes/$1');
    $routes->get('participantes/(:num)/(:num)','Competiciones::verParticipaciones/$1/$2');
    $routes->resource('zonasPesca');
    $routes->resource('capturas');
    $routes->resource('competiciones');
    $routes->resource('participantes');

});
$routes->group('web',['namespace'=>"App\Controllers\web"], function ($routes) {
    $routes->get('', 'Web::index');
});

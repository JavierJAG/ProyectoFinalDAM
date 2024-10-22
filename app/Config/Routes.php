<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->setAutoRoute(false);
$routes->get('/', 'web\Web::index');

service('auth')->routes($routes);

$routes->group('dashboard', ['filter' => 'auth', 'namespace' => "App\Controllers\dashboard"], function ($routes) {
    $routes->get('usuarios', 'Administracion::gestionUsuarios');
    $routes->get('administracion', 'Administracion::index');
    $routes->post('usuario/addAdmin/(:num)', 'Administracion::addAdmin/$1');
    $routes->post('usuario/removeAdmin/(:num)', 'Administracion::removeAdmin/$1');
    $routes->post('usuario/eliminar/(:num)', 'Administracion::eliminarUsuario/$1');
    $routes->resource('especies');
    $routes->resource('localidades');
    $routes->resource('logros');
});
$routes->group('user', ['namespace' => "App\Controllers\user"], function ($routes) {
    $routes->group('perfil', ['namespace' => "App\Controllers\user"], function ($routes) {
        $routes->get('misZonasPesca', 'User::misZonasPesca');
        $routes->get('misCapturas', 'User::misCapturas');
        $routes->get('misLogros', 'User::misLogros');
        $routes->get('misCompeticiones', 'User::misCompeticiones');
        $routes->get('misParticipaciones', 'User::misParticipaciones');
        $routes->get('', 'User::index');
    });
    $routes->get('normativa', 'Normativa::index');
    $routes->post('participantes/otorgarLogro/(:num)/(:num)', 'Competiciones::otorgarLogro/$1/$2');
    $routes->post('participantes/eliminarLogro/(:num)/(:num)/(:num)', 'Competiciones::eliminarLogro/$1/$2/$3');
    $routes->get('buscarCapturas', 'User::verTodasCapturas');
    $routes->get('buscarCompeticiones', 'User::verTodasCompeticiones');
    $routes->post('zonasPesca/get_localidades', 'ZonasPesca::getLocalidades');
    $routes->post('competiciones/get_zonasPesca', 'Competiciones::get_zonasPesca');
    $routes->get('capturas/get_especies', 'Capturas::get_especies');
    $routes->get('participantes/(:num)', 'Competiciones::verParticipantes/$1');
    $routes->get('participantes/(:num)/(:num)', 'Competiciones::verParticipaciones/$1/$2');
    $routes->resource('zonasPesca');
    $routes->resource('capturas');
    $routes->resource('competiciones');
    $routes->resource('participantes');
});
$routes->group('web', ['namespace' => "App\Controllers\web"], function ($routes) {
    $routes->get('', 'Web::index');
});

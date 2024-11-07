<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->setAutoRoute(false);
$routes->get('/', 'web\Web::index');

service('auth')->routes($routes);
$routes->get('captcha/generate', 'CaptchaController::generateCaptcha');
$routes->post('captcha/validate', 'CaptchaController::validateCaptcha');

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
        $routes->post('misCapturas', 'User::misCapturas');
        $routes->get('misLogros', 'User::misLogros');
        $routes->get('misCompeticiones', 'User::misCompeticiones');
        $routes->get('misParticipaciones', 'User::misParticipaciones');
        $routes->get('', 'User::index');
    });
    $routes->get('verModalZonaPesca/(:num)','ZonasPesca::verModalZonaPesca/$1');
    $routes->get('change-password', 'User::changePasswordForm'); 
    $routes->post('change-password', 'User::changePassword');   
    $routes->post('updateProfile','User::updateProfile');
    $routes->get('especies/(:num)', 'Normativa::detalleEspecie/$1');
    $routes->get('especies', 'Normativa::listarEspecies');
    $routes->get('competiciones/anhadirParticipacion/(:num)', 'Competiciones::anhadirParticipacion/$1');
    $routes->post('competiciones/anhadirParticipacion/(:num)', 'Competiciones::crearParticipacion/$1');
    $routes->post('competiciones/participarCompeticion/(:num)', 'Competiciones::participarCompeticion/$1');
    $routes->post('competiciones/eliminarParticipacionCompeticion/(:num)', 'Competiciones::eliminarParticipacionCompeticion/$1');
    $routes->get('buscarCapturas/(:num)', 'User::buscarCapturas/$1');
    $routes->post('buscarCapturas/(:num)', 'User::buscarCapturas/$1');
    $routes->get('buscarLogros/(:num)', 'User::buscarLogros/$1');
    $routes->get('buscar', 'User::buscar');
    $routes->get('perfil/(:num)', 'User::verPerfil/$1');
    $routes->get('salidas', 'Salidas::index');
    $routes->get('salidas/events', 'Salidas::events');
    $routes->post('salidas/saveEvent', 'Salidas::saveEvent');
    $routes->post('salidas/deleteEvent', 'Salidas::deleteEvent');
    $routes->get('normativa', 'Normativa::index');
    $routes->post('participantes/otorgarLogro/(:num)/(:num)', 'Competiciones::otorgarLogro/$1/$2');
    $routes->post('participantes/eliminarLogro/(:num)/(:num)/(:num)', 'Competiciones::eliminarLogro/$1/$2/$3');
    $routes->get('buscarCapturas', 'User::verTodasCapturas');
    $routes->post('buscarCapturas', 'User::verTodasCapturas');
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

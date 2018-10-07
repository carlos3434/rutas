<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    $router->get('rutas',  ['uses' => 'RutaController@showAllRutas']);
    $router->get('rutas/{id}', ['uses' => 'RutaController@showOneRuta']);
    $router->post('rutas', ['uses' => 'RutaController@create']);
    //$router->delete('rutas/{id}', ['uses' => 'RutaController@delete']);
    //$router->put('rutas/{id}', ['uses' => 'RutaController@update']);

    // conductores con su ruta
    $router->get('conductores',  ['uses' => 'ConductorController@showAllConductores']);
    $router->get('conductores/{id}', ['uses' => 'ConductorController@showOneConductor']);
    $router->post('ruta/{id}/conductores', ['uses' => 'ConductorController@create']);
    //$router->delete('conductores/{id}', ['uses' => 'ConductorController@delete']);
    //$router->put('conductores/{id}', ['uses' => 'ConductorController@update']);

});

$router->get('listar-rutas',  ['uses' => 'RutaController@listRutas']);
$router->get('ruta/{id}/listar-conductores',  ['uses' => 'ConductorController@listConductores']);
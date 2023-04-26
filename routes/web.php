<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/clients', 'ClientController@index');
$router->post('/clients', 'ClientController@store');
$router->get('/clients/age-average', 'ClientController@getAgeAverage');
$router->get('/clients/mean-deviation', 'ClientController@getMeanDeviation');
$router->get('/clients/list-with-probability-of-death', 'ClientController@getListWithProbabilityDeath');
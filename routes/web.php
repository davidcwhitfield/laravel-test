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
$router->get('/', [
    'middleware' => 'auth',
    'uses' => 'IndexController@index'
]);

//$router->get('/', 'IndexController@index');

$router->get('videos/update-database', [
    'middleware' => 'auth',
    'uses' => 'VideoController@updateDatabase'
]);

$router->get('/videos/{id}', 'VideoController@findById');

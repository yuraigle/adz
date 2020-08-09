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

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

// Api
$router->group(['prefix' => '/api'], function () use ($router) {
    // Auth
    $router->group(['prefix' => '/auth'], function () use ($router) {
        $router->post('login', 'AuthController@login');
    });

    // Categories REST
    $router->group(['prefix' => '/categories'], function () use ($router) {
        $c = 'CategoriesController';
        $router->get('/', "$c@list");
        $router->post('/', ["middleware" => "auth:admin", "uses" => "$c@create"]);
        $router->put('/{id:[0-9]+}', ["middleware" => "auth:admin", "uses" => "$c@update"]);
        $router->delete('/{id:[0-9]+}', ["middleware" => "auth:admin", "uses" => "$c@delete"]);
    });
});

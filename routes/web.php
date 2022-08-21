<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\NoteController;

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

$router->get('/key', function () {
    return \Illuminate\Support\Str::random(32);
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});

$router->group(['prefix' => 'notes', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'NoteController@index');
    $router->get('/{id}', 'NoteController@show');
    $router->post('/', 'NoteController@store');
    $router->put('/{id}', 'NoteController@update');
    $router->delete('/{id}', 'NoteController@destroy');
});

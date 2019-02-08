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
/**
 * @var \Dingo\Api\Routing\Router $api
 */

if (app()->environment() !== 'production') {
    $api->version('v1',['conditionalRequest' => false],  function ($api) {

        $api->get('/test', 'App\Http\Controllers\Api\V1\TestController@index');
        $api->post('/test', 'App\Http\Controllers\Api\V1\TestController@test');

    });
}

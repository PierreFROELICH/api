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

$api->version('v1', ['conditionalRequest' => false], function ($api) {

    $api->get(
        '/find/best',
        [
            'middleware' => [
                'auth',
                'sanitize:find.get_best',
                'trim:find.get_best',
                'validate:find.get_best',

            ],
            'uses' => 'App\Http\Controllers\Api\V1\FindController@getBest',
        ]
    );


});

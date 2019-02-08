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

$api->version('v1',['conditionalRequest' => false], function ($api) {

    $api->get(
        '/best/{idBest}',
        [
            'middleware' => [
                'auth',
                'bestExists'
            ],
            'uses' => 'App\Http\Controllers\Api\V1\BestController@getBest'
        ]

    );

    $api->post(
        '/best',
        [
            'middleware' => [
                'auth',
                'sanitize:best.create',
                'trim:best.create',
                'validate:best.create',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\BestController@create'
        ]
    );

    $api->put(
        '/best/{idBest}',
        [
            'middleware' => [
                'auth',
                'bestExists',
                'sanitize:best.update',
                'trim:best.update',
                'validate:best.update',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\BestController@update'
        ]
    );

    $api->delete(
        '/best/{idBest}',
        [
            'middleware' => [
                'auth',
                'bestExists',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\BestController@delete'
        ]
    );

    $api->post(
        '/best/like/{idBest}',
        [
            'middleware' => [
                'auth',
                'bestExists'
            ],
            'uses' =>  'App\Http\Controllers\Api\V1\BestController@like'
        ]
    );

    $api->delete(
        '/best/like/{idBest}',
        [
            'middleware' => [
                'auth',
                'bestExists'
            ],
            'uses' => 'App\Http\Controllers\Api\V1\BestController@dislike'
        ]
    );

    $api->get(
        '/bests',
        [
            'middleware' => [
                'auth',
                'usernameInQueryExists'
            ],
            'uses' => 'App\Http\Controllers\Api\V1\BestController@getBests'
        ]
    );

    $api->get(
        '/draft/best',
        [
            'middleware' => [
                'auth',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\BestController@getDrafts'
        ]
    );

});

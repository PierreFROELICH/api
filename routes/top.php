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

$api->version('v1', ['conditionalRequest' => false],function ($api) {

    $api->get(
        '/top/{idTop}',
        [
            'middleware' => ['auth','topExists'],
            'uses' => 'App\Http\Controllers\Api\V1\TopController@getTop'
        ]

    );

    $api->post(
        '/top',
        [
            'middleware' => [
                'auth',
                'jsonValid',
                'sanitizeJson:top.create',
                'trimJson:top.create',
                'validateJson:top.create',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@create'
        ]
    );

    $api->put(
        '/top/{idTop}',
        [
            'middleware' => [
                'auth',
                'jsonValid',
                'sanitizeJson:top.update',
                'trimJson:top.update',
                'validateJson:top.update',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\TopController@update'
        ]
    );


    $api->post(
        '/top/like/{idTop}',
        [
            'middleware' => ['auth','topExists'],
            'uses' =>  'App\Http\Controllers\Api\V1\TopController@like'
        ]
    );

    $api->delete(
        '/top/like/{idTop}',
        [
            'middleware' => ['auth','topExists'],
            'uses' => 'App\Http\Controllers\Api\V1\TopController@dislike'
        ]
    );

});

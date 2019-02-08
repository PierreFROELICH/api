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
        '/home/best',
        [
            'middleware' => [
                'auth',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getHomeBest',
        ]
    );

    $api->get(
        '/home/best/bydate',
        [
            'middleware' => [
                'auth',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getHomeBestByDate',
        ]
    );

    $api->get(
        '/suggestion/friend',
        [
            'middleware' => [
                'auth',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getSuggestionFriend',
        ]
    );

    $api->get(
        '/suggestion/theme',
        [
            'middleware' => [
                'auth',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getSuggestionTheme',
        ]
    );


    $api->get(
        '/best/bycategory/all',
        [
            'middleware' => [
                'auth',
                'sanitize:flux.get_best_by_category_all',
                'trim:flux.get_best_by_category_all',
                'validate:flux.get_best_by_category_all',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getBestByCategoryAll',
        ]
    );

    $api->get(
        '/best/bycategory/around',
        [
            'middleware' => [
                'auth',
                'sanitize:flux.get_best_by_category_around',
                'trim:flux.get_best_by_category_around',
                'validate:flux.get_best_by_category_around',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getBestByCategoryAround',
        ]
    );

    $api->get(
        '/best/bycategory/friends',
        [
            'middleware' => [
                'auth',
                'sanitize:flux.get_best_by_category_friends',
                'trim:flux.get_best_by_category_friends',
                'validate:flux.get_best_by_category_friends',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getBestByCategoryFriends',
        ]
    );

    $api->get(
        '/best/bycategory/my',
        [
            'middleware' => [
                'auth',
                'sanitize:flux.get_best_by_category_my',
                'trim:flux.get_best_by_category_my',
                'validate:flux.get_best_by_category_my',

            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getBestByCategoryMy',
        ]
    );

///
    $api->get(
        '/best/bybest/all',
        [
            'middleware' => [
                'auth',
                'sanitize:flux.get_best_by_best_all',
                'trim:flux.get_best_by_best_all',
                'validate:flux.get_best_by_best_all',

            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getBestByBestAll',
        ]
    );

    $api->get(
        '/best/bybest/around',
        [
            'middleware' => [
                'auth',
                'sanitize:flux.get_best_by_best_around',
                'trim:flux.get_best_by_best_around',
                'validate:flux.get_best_by_best_around',

            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getBestByBestAround',
        ]
    );

    $api->get(
        '/best/bybest/friends',
        [
            'middleware' => [
                'auth',
                'sanitize:flux.get_best_by_best_friends',
                'trim:flux.get_best_by_best_around',
                'validate:flux.get_best_by_best_friends',

            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getBestByBestFriends',
        ]
    );

    $api->get(
        '/best/bybest/my',
        [
            'middleware' => [
                'auth',
                'sanitize:flux.get_best_by_best_my',
                'trim:flux.get_best_by_best_my',
                'validate:flux.get_best_by_best_my',

            ],
            'uses' => 'App\Http\Controllers\Api\V1\FluxController@getBestByBestMy',
        ]
    );


});

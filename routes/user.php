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

    $api->post(
        '/user/login',
        [
            'middleware' =>
                [
                    'sanitize:user.login',
                    'trim:user.login',
               ],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@login',
        ]

    );



    $api->get(
        '/user/check_login',
        [
            'middleware' =>
                [
                    'sanitize:user.check_login',
                ],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@checkLogin',
        ]

    );

    $api->patch(
        '/user/logout',
        [
            'middleware' => [
                'auth',
                'sanitize:user.logout',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@logout',
        ]
    );

    $api->get(
        '/user/{username}',
        [
            'middleware' => ['auth','usernameInPathExists'],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@getUser'
        ]

    );

    $api->post(
        '/user',
        [
            'middleware' => [
                'sanitize:user.create',
                'trim:user.create',
                'validate:user.create',
                ],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@create'
        ]
    );

    $api->post(
        '/user/update',
        [
            'middleware' => [
                'auth',
                'sanitize:user.update',
                'trim:user.update',
                'validate:user.update',
            ],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@update'
        ]
    );

    //on s'abonne
    $api->post(
        '/user/follow/{username}',
        [
            'middleware' => ['auth','usernameInPathExists'],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@follow'
        ]
    );

    $api->delete(
        '/user/follow/{username}',
        [
            'middleware' => ['auth','usernameInPathExists'],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@unfollow'
        ]
    );

    $api->patch(
        '/user/tags',
        [
            'middleware' => [
                'auth',
                'jsonValid',
                'sanitizeJson:user.save_tags',
                'trimJson:user.save_tags',
                'validatejson:user.save_tags'
            ],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@saveTags'
        ]
    );

    $api->get(
        '/user/tags/{username}',
        [
            'middleware' => ['auth','usernameInPathExists'],
            'uses' => 'App\Http\Controllers\Api\V1\UserController@getTags'
        ]
    );

    //Les abonnés du username
    $api->get(
        '/following',
        [
            'middleware' => ['auth','usernameInQueryExists'],
            'uses' => 'App\Http\Controllers\Api\V1\FollowingController@getFollowing'
        ]
    );

    $api->get(
        '/count/following/{username}',
        [
            'middleware' => ['auth','usernameInPathExists'],
            'uses' => 'App\Http\Controllers\Api\V1\FollowingController@getCountFollowing'
        ]
    );

    //les suiveurs du username
    $api->get(
        '/follower',
        [
            'middleware' => ['auth','usernameInQueryExists'],
            'uses' => 'App\Http\Controllers\Api\V1\FollowerController@getFollower'
        ]
    );

    $api->get(
        '/count/follower/{username}',
        [
            'middleware' => ['auth','usernameInPathExists'],
            'uses' => 'App\Http\Controllers\Api\V1\FollowerController@getCountFollower'
        ]
    );

});

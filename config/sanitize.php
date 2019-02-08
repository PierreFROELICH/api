<?php
return [
    'user' => [
        'login' => [
            'email' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING,
        ],
        'check_login' => [
            'guid' => FILTER_SANITIZE_STRING,
            'token' => FILTER_SANITIZE_STRING,
        ],
        'logout' => [
            'guid' => FILTER_SANITIZE_STRING,
            'token' => FILTER_SANITIZE_STRING,
        ],
        'create' => [
            'email' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING,
            'username' => FILTER_SANITIZE_STRING,
            'firstName' => FILTER_SANITIZE_STRING,
            'lastName' => FILTER_SANITIZE_STRING,
            'phone' => FILTER_SANITIZE_STRING,
            'latitude' => FILTER_SANITIZE_STRING,
            'longitude' => FILTER_SANITIZE_STRING,
            'place' => FILTER_SANITIZE_STRING,
            'address' => FILTER_SANITIZE_STRING,
            'url' => FILTER_SANITIZE_STRING,
            '*.tags' => FILTER_SANITIZE_STRING,
        ],
        'update' => [
            'firstName' => FILTER_SANITIZE_STRING,
            'lastName' => FILTER_SANITIZE_STRING,
            'phone' => FILTER_SANITIZE_STRING,
            'latitude' => FILTER_SANITIZE_STRING,
            'longitude' => FILTER_SANITIZE_STRING,
            'place' => FILTER_SANITIZE_STRING,
            'address' => FILTER_SANITIZE_STRING,
            'url' => FILTER_SANITIZE_STRING,
        ],
        'save_tags' => [
            '*.tags' => FILTER_SANITIZE_STRING,
        ],
    ],
    'best' => [
        'create' => [
            'type' => FILTER_SANITIZE_STRING,
            'title' => FILTER_SANITIZE_STRING,
            'description' => FILTER_SANITIZE_STRING,
            'status' => FILTER_SANITIZE_STRING,
            'url' => FILTER_SANITIZE_STRING,
            'latitude' => FILTER_SANITIZE_STRING,
            'longitude' => FILTER_SANITIZE_STRING,
            'place' => FILTER_SANITIZE_STRING,
            'address' => FILTER_SANITIZE_STRING,
            '*.category' => FILTER_SANITIZE_STRING,
        ],
        'update' => [
            'type' => FILTER_SANITIZE_STRING,
            'title' => FILTER_SANITIZE_STRING,
            'description' => FILTER_SANITIZE_STRING,
            'status' => FILTER_SANITIZE_STRING,
            'url' => FILTER_SANITIZE_STRING,
            'latitude' => FILTER_SANITIZE_STRING,
            'longitude' => FILTER_SANITIZE_STRING,
            'place' => FILTER_SANITIZE_STRING,
            'address' => FILTER_SANITIZE_STRING,
            '*.category' => FILTER_SANITIZE_STRING,
        ],
    ],
    'flux' => [
        'get_best_by_best_all' => [
            'idBest' => FILTER_SANITIZE_STRING,
            'offset' => FILTER_SANITIZE_STRING,
            'limit' => FILTER_SANITIZE_STRING,
        ],
        'get_best_by_category_all' => [
            'category' => FILTER_SANITIZE_STRING,
            'offset' => FILTER_SANITIZE_STRING,
            'limit' => FILTER_SANITIZE_STRING,
        ],
        'get_best_by_best_around' => [
            'idBest' => FILTER_SANITIZE_STRING,
            'offset' => FILTER_SANITIZE_STRING,
            'limit' => FILTER_SANITIZE_STRING,
            'latitude' => FILTER_SANITIZE_STRING,
            'longitude' => FILTER_SANITIZE_STRING,

            'distance' => FILTER_SANITIZE_STRING,

        ],
        'get_best_by_category_around' => [
            'category' => FILTER_SANITIZE_STRING,
            'offset' => FILTER_SANITIZE_STRING,
            'limit' => FILTER_SANITIZE_STRING,
            'latitude' => FILTER_SANITIZE_STRING,
            'longitude' => FILTER_SANITIZE_STRING,
            'distance' => FILTER_SANITIZE_STRING,

        ],
        'get_best_by_best_friends' => [
            'idBest' => FILTER_SANITIZE_STRING,
            'offset' => FILTER_SANITIZE_STRING,
            'limit' => FILTER_SANITIZE_STRING,
        ],
        'get_best_by_category_friends' => [
            'category' => FILTER_SANITIZE_STRING,
            'offset' => FILTER_SANITIZE_STRING,
            'limit' => FILTER_SANITIZE_STRING,
        ],
        'get_best_by_best_my' => [
            'idBest' => FILTER_SANITIZE_STRING,
            'offset' => FILTER_SANITIZE_STRING,
            'limit' => FILTER_SANITIZE_STRING,
        ],
        'get_best_by_category_my' => [
            'category' => FILTER_SANITIZE_STRING,
            'offset' => FILTER_SANITIZE_STRING,
            'limit' => FILTER_SANITIZE_STRING,
        ],
    ],
    'find' => [
        'get_best' => [
            'q' => FILTER_SANITIZE_STRING,
            'offset' => FILTER_SANITIZE_STRING,
            'limit' => FILTER_SANITIZE_STRING,
        ],

    ]
];

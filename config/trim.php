<?php
return [
    'user' => [
        'login' => [
            'email' => false,
        ],
        'create' => [
            'email' => false,
            'username' => false,
            'firstName' => true,
            'lastName' => true,
            'phone' => true,
            'latitude' => true,
            'longitude' => true,
            'place' => true,
            'address' => true,
            'url' => true,
            '*.tags' => true,
        ],
        'update' => [
            'firstName' => true,
            'lastName' => true,
            'phone' => true,
            'latitude' => true,
            'longitude' => true,
            'place' => true,
            'address' => true,
            'url' => true,

        ],
        'save_tags' => [
            '*.tags' => true,
        ],
    ],
    'best' => [
        'create' => [
            'type' => true,
            'title' => true,
            'description' => true,
            'status' => true,
            'url' => true,
            'latitude' => true,
            'longitude' => true,
            'place' => true,
            'address' => true,
            '*.category' => true,
        ],
        'update' => [
            'type' => true,
            'title' => true,
            'description' => true,
            'status' => true,
            'url' => true,
            'latitude' => true,
            'longitude' => true,
            'place' => true,
            'address' => true,
            '*.category' => true,
        ],
    ],

    'flux' => [
        'get_best_by_category_all' => [
            'category' => false,
            'offset' => true,
            'limit' => true,
        ],
        'get_best_by_best_all' => [
            'idBest' => true,
            'offset' => true,
            'limit' => true,
        ],
        'get_best_by_best_around' => [
            'idBest' => true,
            'offset' => true,
            'limit' => true,
            'latitude' => true,
            'longitude' => true,
            'distance' => true,

        ],
        'get_best_by_category_around' => [
            'category' => false,
            'offset' => true,
            'limit' => true,
            'latitude' => true,
            'longitude' => true,
            'distance' => true,

        ],
        'get_best_by_category_friends' => [
            'category' => false,
            'offset' => true,
            'limit' => true,
        ],
        'get_best_by_best_friends' => [
            'idBest' => true,
            'offset' => true,
            'limit' => true,
        ],
        'get_best_by_category_my' => [
            'category' => false,
            'offset' => true,
            'limit' => true,
        ],
        'get_best_by_best_my' => [
            'idBest' => true,
            'offset' => true,
            'limit' => true,
        ],
    ],
    'find' => [
        'get_best' => [
            'q' => true,
            'offset' => true,
            'limit' => true,
        ],

    ]
];

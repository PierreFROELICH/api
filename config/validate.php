<?php
return [
    'user' => [
        'create' => [
            'rules' => [
                'username' => ['required', 'max:45', 'unique:utilisateur,pseudo'],
                'password' => ['required', 'min:8'],
                'email' => ['required', 'max:255', 'email','unique:utilisateur,email'],
                'firstName' => ['nullable', 'max:45'],
                'lastName' => ['nullable', 'max:45'],
                'phone' => ['nullable', 'max:16'],
                'latitude' => ['nullable', 'numeric'],
                'longitude' => ['nullable', 'numeric'],
                'place' => ['nullable', 'max:255'],
                'address' => ['nullable', 'max:255'],
                'url' => ['nullable', 'max:128'],
                'file' => ['nullable', 'image_base64:png,jpeg,jpg,gif'],
                'tags.*' => ['nullable', 'max:45'],

            ],
            'message' => 'Could not create new user.',
        ],

        'update' => [
            'rules' => [
                'firstName' => ['nullable', 'max:45'],
                'lastName' => ['nullable', 'max:45'],
                'phone' => ['nullable', 'max:16'],
                'latitude' => ['nullable', 'numeric'],
                'longitude' => ['nullable', 'numeric'],
                'place' => ['nullable', 'max:255'],
                'address' => ['nullable', 'max:255'],
                'url' => ['nullable', 'max:128'],
                'file' => ['nullable', 'image_base64:png,jpeg,jpg,gif'],
            ],
            'message' => 'Could not update  user.',
        ],
        'save_tags' => [
            'rules' => [
                'tags.*' => ['required', 'max:45'],
            ],
            'message' => 'Could not save tags.',
        ],
    ],
    'best' => [
        'create' => [
            'rules' => [
                'type' => ['nullable', 'in:photo,video,lien,geo,autre'],
                'title' => ['required', 'max:45'],
                'description' => ['required', 'max:512'],
                'status' => ['nullable', 'in:draft,to_publish'],
                'url' => ['nullable', 'max:128'],
                'latitude' => ['nullable', 'numeric'],
                'longitude' => ['nullable', 'numeric'],
                'place' => ['nullable', 'max:255'],
                'address' => ['nullable', 'max:255'],
                'file' => ['nullable', 'image_base64:png,jpeg,jpg,gif'],
                'category.*' => ['required', 'max:45'],
            ],
            'message' => 'Could not create new best.',
        ],
        'update' => [
            'rules' => [
                'type' => ['nullable', 'in:photo,video,lien,geo,autre'],
                'title' => ['nullable', 'max:45'],
                'description' => ['nullable', 'max:512'],
                'status' => ['nullable', 'in:draft,to_publish'],
                'url' => ['nullable', 'max:128'],
                'latitude' => ['nullable', 'numeric'],
                'longitude' => ['nullable', 'numeric'],
                'place' => ['nullable', 'max:255'],
                'address' => ['nullable', 'max:255'],
                'file' => ['nullable', 'image_base64:png,jpeg,jpg,gif'],
                'category.*' => ['required', 'max:45'],
            ],
            'message' => 'Could not update best.',
        ],
    ],
    'flux' => [
        'get_best_by_category_all' => [
            'rules' => [
                'category' => ['nullable', 'max:45'],
                'offset' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
            ],
            'message' => 'Invalide parameers.',
        ],
        'get_best_by_best_all' => [
            'rules' => [

                'idBest' => ['nullable', 'numeric'],
                'offset' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
            ],
            'message' => 'Invalide parameers.',

        ],
        'get_best_by_best_around' => [
            'rules' => [

                'idBest' => ['nullable', 'numeric'],
                'offset' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
                'latitude' => ['nullable', 'numeric'],
                'longitude' => ['nullable', 'numeric'],
                'distance' => ['nullable', 'numeric'],
            ],
            'message' => 'Invalide parameers.',

        ],
        'get_best_by_category_around' => [
            'rules' => [

                'category' => ['nullable', 'max:45'],
                'offset' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
                'latitude' => ['nullable', 'numeric'],
                'longitude' => ['nullable', 'numeric'],
                'distance' => ['nullable', 'numeric'],
            ],
            'message' => 'Invalide parameers.',

        ],
        'get_best_by_category_friends' => [
            'rules' => [
                'category' => ['nullable', 'max:45'],
                'offset' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
            ],
            'message' => 'Invalide parameers.',
        ],
        'get_best_by_best_friends' => [
            'rules' => [

                'idBest' => ['nullable', 'numeric'],
                'offset' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
            ],
            'message' => 'Invalide parameers.',

        ],
        'get_best_by_category_my' => [
            'rules' => [
                'category' => ['nullable', 'max:45'],
                'offset' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
            ],
            'message' => 'Invalide parameers.',
        ],
        'get_best_by_best_my' => [
            'rules' => [

                'idBest' => ['nullable', 'numeric'],
                'offset' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
            ],
            'message' => 'Invalide parameers.',

        ],
    ],
    'find' => [
        'get_best' => [
            'rules' => [
                'q' => ['required', 'max:255'],
                'offset' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
            ],
            'message' => 'Invalide parameters.',
        ],
    ]
];

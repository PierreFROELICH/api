<?php

return [

    'image' => [
        'driver' => env('DEPOT_IMAGE_DRIVER'),
        'host' => env('DEPOT_IMAGE_HOST'),
        'username' => env('DEPOT_IMAGE_LOGIN'),
        'password' => env('DEPOT__IMAGE_PASSWORD'),
        'port' => env('DEPOT_IMAGE_PORT'),
        'passive' => env('DEPOT_IMAGE_PASSIVE'),

    ],

];

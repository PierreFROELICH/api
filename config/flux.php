<?php
return [
    'home' => [
        'best' => [
            'orderBy' => [
                [
                    'field' => 'date_publication',
                    'order' => 'desc',
                ],
                [
                    'field' => DB::raw('(best.nb_like-DATEDIFF( NOW(),  best.date_dernier_like))'),
                    'order' => 'desc',
                ],
                [
                    'field' => 'celebrite',
                    'order' => 'desc',
                ],


            ],
        ],
    ],
    'categorie' => [
        'best' => [
            'orderBy' => [
                [
                    'field' => DB::raw('(best.nb_like-DATEDIFF( NOW(),  best.date_dernier_like))'),
                    'order' => 'desc',
                ],
                [
                    'field' => DB::raw('poids'),
                    'order' => 'desc',
                ],
                [
                    'field' => 'utilisateur.celebrite',
                    'order' => 'desc',
                ],
                [
                    'field' => 'best.date_publication',
                    'order' => 'desc',
                ],
            ],
        ],
    ],

    'find' => [
        'best' => [
            'orderBy' => [
                [
                    'field' => DB::raw('pertinence'),
                    'order' => 'desc',
                ],
                [
                    'field' => DB::raw('(best.nb_like-DATEDIFF( NOW(),  best.date_dernier_like))'),
                    'order' => 'desc',
                ],
                [
                    'field' => DB::raw('poids'),
                    'order' => 'desc',
                ],
                [
                    'field' => 'utilisateur.celebrite',
                    'order' => 'desc',
                ],
                [
                    'field' => 'best.date_publication',
                    'order' => 'desc',
                ],
            ],
        ],
]
];


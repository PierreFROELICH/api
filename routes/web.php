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


$router->get('/',
    [
        function () {
            //return $router->app->version();
            return env('API_NAME');
        },
    ]);

$router->get('/process/poids',
    [
        function () {
            try {
// àtodo : prevoir de passer des plage d'idutilisateur 0-500, 501-1001, ...
                \App\Services\Poids::process();

            } catch (\Exception $exception) {
                \Illuminate\Support\Facades\Log::error(
                    print_r(
                        [
                            'method' => __METHOD__,
                            'Exception' => [
                                'code' => $exception->getCode(),
                                'message' => $exception->getMessage(),
                                'trace' => $exception->getTraceAsString(),
                            ],
                        ], true)
                );

                return -1;
            }

            return 0;
        },
    ]
);


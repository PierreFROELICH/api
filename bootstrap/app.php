<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->withFacades();

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    App\Http\Middleware\LogAllRequests::class,
    App\Http\Middleware\PreflightResponse::class,
]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'usernameInPathExists' => App\Http\Middleware\UsernameInPathExists::class,
    'usernameInQueryExists' => App\Http\Middleware\UsernameInQueryExists::class,
    'bestExists' => App\Http\Middleware\BestExists::class,
    'topExists' => App\Http\Middleware\TopExists::class,
    'preflightResponse' => App\Http\Middleware\PreflightResponse::class,

    'sanitize' => App\Http\Middleware\Sanitize::class,
    'trim' => App\Http\Middleware\Trim::class,
    'validate' => App\Http\Middleware\Validate::class,

    'jsonValid' => App\Http\Middleware\JsonValid::class,

    'sanitizeJson' => App\Http\Middleware\SanitizeJson::class,
    'trimJson' => App\Http\Middleware\TrimJson::class,
    'validatejson' => App\Http\Middleware\ValidateJson::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(Dingo\Api\Provider\LumenServiceProvider::class);
//if ($this->app->environment() !== 'production') {
//}

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {

    /**
     * @var \Dingo\Api\Routing\Router $api
     */
    $api = app(\Dingo\Api\Routing\Router::class);

    require __DIR__ . '/../routes/web.php';
    require __DIR__ . '/../routes/user.php';
    require __DIR__ . '/../routes/best.php';
    require __DIR__ . '/../routes/top.php';
    require __DIR__ . '/../routes/flux.php';
    require __DIR__ . '/../routes/recherche.php';


    require __DIR__ . '/../routes/test.php';


});

return $app;

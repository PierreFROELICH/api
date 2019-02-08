<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;

class LogAllRequests
{

    public function handle($request, \Closure $next)
    {
      //  Log::info('var', [
                //'get' => $_GET,
                //'post' => $_POST,
                //'files' => $_FILES,
                //'request' => $_REQUEST,
                //'input' => $_file_get_contents("php://input"),
       //     ]
       // );
        $response = $next($request);

        Log::info('Request', [
            'request' => $request,
            'response' => $response,
        ]);



        return $response;
    }


}

<?php

namespace App\Http\Middleware;


use App\Services\Registry;
use Closure;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Validator;

class JsonValid
{
    /**
     * Handle an incoming request.
     *
     * @param \Dingo\Api\Http\Request $request
     * @param \Closure                $next
     * @param                         $key
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make(
            [
                'json' => $request->getContent(),
            ],
            [
                'json' => 'json',
            ]
        );

        
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException(
                'Not a json valide',
                $validator->errors()
            );
        }

        Registry::put('request_json', \json_decode($request->getContent(), true));

        return $next($request);
    }
}

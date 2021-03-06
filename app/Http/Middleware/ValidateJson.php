<?php

namespace App\Http\Middleware;

use App\Services\Registry;
use Closure;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateJson
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
    public function handle(Request $request, Closure $next, $key)
    {
        config(['validate' => include app()->basePath() . '/config/validate.php']);

        $validator = Validator::make(
           Registry::get('request_json'),
            config('validate.' . $key . '.rules')
        );

        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException(config('validate.' . $key . '.message'),
                $validator->errors());
        }

        return $next($request);
    }
}

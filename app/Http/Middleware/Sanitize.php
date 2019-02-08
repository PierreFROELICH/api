<?php

namespace App\Http\Middleware;


use App\Traits\SanitizeTraits;
use Closure;
use Dingo\Api\Http\Request;

class Sanitize
{
    use SanitizeTraits;

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
        config(['sanitize' => include app()->basePath() . '/config/sanitize.php']);

        $this->sanitize($request, config('sanitize.' . $key));

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Traits\TrimTraits;
use Closure;
use Dingo\Api\Http\Request;

class Trim
{
    use TrimTraits;

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
        config(['trim' => include app()->basePath() . '/config/trim.php']);
        $this->trim($request, config('trim.' . $key));

        return $next($request);
    }
}

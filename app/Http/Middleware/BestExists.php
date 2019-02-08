<?php

namespace App\Http\Middleware;

use App\Helpers\StringHelper;
use App\Models\Best\Best;
use App\Services\Registry;
use Closure;
use Dingo\Api\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BestExists
{
    /**
     * @var \App\Models\Best\Best
     */
    protected $best;

    /**
     * BestExists constructor.
     *
     * @param \App\Models\Best\Best $best
     */
    public function __construct(Best $best)
    {
        $this->best = $best;
    }

    /**
     * Handle an incoming request.
     */

    /**
     * @param          $request
     * @param \Closure $next
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        //print_r($route);
        $idbest = trim(StringHelper::sanitize($route[2]['idBest']));

        $best = Best::where(
            'id_best',
            $idbest
        )
            ->first();

        if (!$best) {
            throw new HttpException(404, 'Best not found');
        }
        Registry::put('route_best', $best);

        return $next($request);
    }
}

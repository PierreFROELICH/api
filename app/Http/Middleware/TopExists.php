<?php

namespace App\Http\Middleware;

use App\Helpers\StringHelper;
use App\Models\Top\Top;
use App\Services\Registry;
use Closure;
use Dingo\Api\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TopExists
{
    /**
     * @var Top
     */
    protected $top;

    /**
     * TopExists constructor.
     *
     * @param \App\Models\Top\Top $top
     */

    public function __construct(Top $top)
    {
        $this->top = $top;
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
        $idtop = trim(StringHelper::sanitize($route[2]['idTop']));

        $top = Top::where(
            'id_top',
            $idtop
        )
            ->first();

        if (!$top) {
            throw new HttpException(404, 'Top not found');
        }
        Registry::put('route_top', $top);

        return $next($request);
    }
}

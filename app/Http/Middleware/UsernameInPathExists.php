<?php

namespace App\Http\Middleware;

use App\Helpers\StringHelper;
use App\Models\Utilisateur\Utilisateur;
use App\Services\Registry;
use Closure;
use Dingo\Api\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UsernameInPathExists
{
    /**
     * @var Utilisateur
     */
    protected $utilisateur;

    /**
     * UsernameExists constructor.
     *
     * @param \App\Models\Utilisateur\Utilisateur $utilisateur
     */
    public function __construct(Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;
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
        $username = trim(StringHelper::sanitize($route[2]['username']));

        $user = Utilisateur::where(
            'pseudo',
            $username
        )
            ->whereIn(
                'status',
                [
                    'en_attente_validation',
                    'certifie',

                ]
            )
            ->whereNull('date_suppression')
            ->first();
        if (!$user) {
            throw new HttpException(404, 'User not found');
        }
        Registry::put('route_username', $user);

        return $next($request);
    }
}

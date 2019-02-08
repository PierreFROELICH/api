<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Utilisateur\SuiviPar;
use App\Models\Utilisateur\Utilisateur;
use App\Services\Registry;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class FollowingController
 *
 * @package App\Http\Controllers\Api\V1
 */
class FollowingController extends ApiController
{


    /**
     *
     */
    public function index()
    {
        $this->response->errorBadRequest();
    }


    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     */
    public function getFollowing(Request $request)
    {
        $me = Auth::user();
        $user = Registry::get('route_username');
        $limit = $request->input('limit', 50);
        $offset = $request->input('offset', 0);

        return SuiviPar::transform(
            Utilisateur::getFollowing($user['id_utilisateur'],
                $limit,
                $offset,
                $me['id_utilisateur'])
        );
    }

    /**
     * @param string $username
     *
     * @return int
     */
    public function getCountFollowing(string $username) : int
    {
        $user = Registry::get('route_username');

        return Utilisateur::getCountFollowing($user['id_utilisateur']);
    }
}

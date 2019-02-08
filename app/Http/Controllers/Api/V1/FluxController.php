<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\ApiController;
use App\Services\BestService;
use App\Services\CategorieService;
use App\Services\FriendService;
use App\Services\ThemeService;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * Class FluxController
 *
 * @package App\Http\Controllers\Api\V1
 */
class FluxController extends ApiController
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
    public function getHomeBest(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        return $this->response()
            ->array(
                BestService::fluxHome($user['id_utilisateur'], $limit, $offset)
            );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     */
    public function getHomeBestByDate(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        return $this->response()
            ->array(
                BestService::fluxHomeByDate($user['id_utilisateur'], $limit, $offset)
            );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     */
    public function getSuggestionFriend(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        return $this->response()
            ->array(
                FriendService::fluxFriend($user['id_utilisateur'], $limit, $offset)
            );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     */
    public function getSuggestionTheme(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        return $this->response()
            ->array(
                ThemeService::fluxTheme($user['id_utilisateur'], $limit, $offset)
            );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return array
     */
    public function getBestByBestAll(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $idBest = $request->input('idBest', 0);
        $categorie = BestService::AllMotsCles($idBest);

        return CategorieService::fluxBestAll(
            $user['id_utilisateur'],
            $categorie,
            $limit,
            $offset
        );
    }

    //fluxBestFiend
    public function getBestByBestFriends(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $idBest = $request->input('idBest', 0);
        $categorie = BestService::AllMotsCles($idBest);

        return CategorieService::fluxBestFriends(
            $user['id_utilisateur'],
            $categorie,
            $limit,
            $offset
        );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return array
     */
    public function getBestByBestAround(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        $idBest = $request->input('idBest', 0);
        $latitude = $request->input('latitude', $user['latitude']);
        $longitude = $request->input('longitude', $user['longitude']);
        $distance = $request->input('distance', 1);

        $categorie = BestService::AllMotsCles($idBest);

        return CategorieService::fluxBestAround(
            $user['id_utilisateur'],
            $categorie,
            (int)$latitude,
            (int)$longitude,
            (int)$distance,
            $limit,
            $offset
        );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     */
    public function getBestByBestMy(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        $idBest = $request->input('idBest', 0);

        $categorie = BestService::AllMotsCles($idBest);

        return CategorieService::fluxBestMy(
            $user['id_utilisateur'],
            $categorie,
            $limit,
            $offset
        );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return array
     */
    public function getBestByCategoryAll(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $categorie = $request->input('category', '');

        return CategorieService::fluxBestAll(
            $user['id_utilisateur'],
            [$categorie],
            $limit,
            $offset
        );
    }

    ///flucCategorieFiend
    public function getBestByCategoryFriends(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $categorie = $request->input('category', '');

        return CategorieService::fluxBestFriends(
            $user['id_utilisateur'],
            [$categorie],
            $limit,
            $offset
        );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return array
     */
    public function getBestByCategoryAround(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        $categorie = $request->input('category', '');
        $latitude = $request->input('latitude', $user['latitude']);
        $longitude = $request->input('longitude', $user['longitude']);
        $distance = $request->input('distance', 1);

        return CategorieService::fluxBestAround(
            $user['id_utilisateur'],
            [$categorie],
            (int)$latitude,
            (int)$longitude,
            (int)$distance,
            $limit,
            $offset
        );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     */
    public function getBestByCategoryMy(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        $categorie = $request->input('category', 0);

        return CategorieService::fluxBestMy(
            $user['id_utilisateur'],
            [$categorie],
            $limit,
            $offset
        );
    }

}

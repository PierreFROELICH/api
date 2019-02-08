<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\CelebriteHelper;
use App\Http\Controllers\Api\ApiController;
use App\Models\Top\Top;
use App\Models\Top\TopLikePar;
use App\Services\Registry;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


/**
 * Class TopController
 *
 * @package App\Http\Controllers\Api\V1
 */
class TopController extends ApiController
{

    /**
     *
     */
    public function index()
    {
        $this->response->errorBadRequest();
    }


    /**
     * @param int $idTop
     *
     * @return int
     */
    public function like(int $idTop): int
    {
        $user = Auth::user();
        $top = Registry::get('route_top');

        if (count($this->selectLike($user['id_utilisateur'], $top['id_top'])->get()) == 0) {

            TopLikePar::UpdateOrCreate(
                    [
                        'id_top_fk' => $top['id_top'],
                        'id_utilisateur_fk' => $user['id_utilisateur'],
                    ],
                    [
                        'date_suppression' => null,
                    ]
                );
            CelebriteHelper::likeTop($top['id_utilisateur_fk']);

        }

        return Top::majCOmpteur($idTop);

    }


    /**
     * @param int $idTop
     *
     * @return int
     */
    public function dislike(int $idTop): int
    {
        $user = Auth::user();
        $top = Registry::get('route_top');

        if (count($this->selectLike($user['id_utilisateur'], $top['id_top'])->get())) {

            $this
                ->selectLike($user['id_utilisateur'], $top['id_top'])
                ->update(
                    [
                        'date_suppression' => Carbon::now(),
                    ]
                );
            CelebriteHelper::dislikeTop($top['id_utilisateur_fk']);
        }

        return Top::majCOmpteur($idTop);

    }

    /**
     * @param int $idutilisateur
     * @param int $idtop
     *
     * @return mixed
     */
    protected function selectLike(int $idutilisateur, int $idtop)
    {
        return TopLikePar::where(
            'id_utilisateur_fk',
            $idutilisateur
        )->where(
            'id_top_fk',
            $idtop
        )->whereNull(
            'date_suppression'
        );
    }
}

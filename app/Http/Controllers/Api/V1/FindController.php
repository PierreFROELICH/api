<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\ApiController;
use App\Models\MotCle;
use App\Models\Recherche\Recherche;
use App\Models\Recherche\RechercheInfos;
use App\Models\Recherche\RechercheTag;
use App\Services\FindService;
use Dingo\Api\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class FluxController
 *
 * @package App\Http\Controllers\Api\V1
 */
class FindController extends ApiController
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
    public function getBest(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $q = $request->input('q', 10);

        if (empty($offset)) {
            $offset = 0;
        }

        if (empty($limit)) {
            $limit = 0;
        }

        $mots = [];
        $motsBrut = explode(' ', $q);
        foreach ($motsBrut as $mot) {
            $mot = trim($mot);
            if (!empty($mot)) {
                $mots[$mot] = $mot;
            }
        }

        if (empty($mots)) {
            throw new UnprocessableEntityHttpException('Invalide parameters.');
        }

        $recherche = Recherche::UpdateOrcreate(
            [
                'q' => $q,
                'id_utilisateur_fk' => $user['id_utilisateur'],
            ],
            [
            ]
        );


        RechercheInfos::Create(
            [
                'id_recherche_fk' => $recherche['id_recherche'],
                'offset' => $offset,
                'limit' => $limit,
                'date_recherche' => Carbon::now(),
            ]
        );

        $this->saveTags(
            $mots,
            $recherche['id_recherche']
        );


        return $this->response()
            ->array(
                FindService::findBest($user['id_utilisateur'], $mots, $limit, $offset)
            );
    }

    /**
     * @param $tags
     * @param $idrecherche
     */
    protected function saveTags($tags, $idrecherche)
    {
        //on enregistre les category
        if (!is_array($tags)) {
            return;
        }
        RechercheTag::whereNotIn(
            'mot_cle',
            $tags
        )
            ->where(
                'id_recherche_fk',
                $idrecherche
            )
            ->delete();

        foreach ($tags as $motcle) {
            $tag = MotCle::where(
                'libelle',
                $motcle
            )->first();

            RechercheTag::UpdateOrCreate(
                [
                    'id_recherche_fk' => $idrecherche,
                    'mot_cle' => $motcle,
                ],
                [
                    'id_mot_cle_fk' => $tag['id_mot_cle'] ?? null,
                ]
            );
        }
    }
}

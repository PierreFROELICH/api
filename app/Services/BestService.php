<?php

namespace App\Services;

use App\Models\Best\Best;
use App\Models\Best\BestLikePar;
use App\Models\Utilisateur\SuiviPar;
use Illuminate\Support\Facades\Auth;

/**
 * Class CelebriteHelper
 *
 * @package App\Helpers
 */
class BestService
{

    /**
     * @param \App\Models\Best\Best $best
     *
     * @return array
     */
    static function toAPi(Best $best)
    {
        //@todo : factoriser les following et folower
        $moi = Auth::user();
        $response = $best->toApi();
        $response['like_by_me'] = (
            app(BestLikePar::class)
                ->estLikePar(
                    $moi['id_utilisateur'],
                    $best['id_best']
                ) != null
        );

        $user = $best->utilisateur();
        $response['user'] = $user->toApi($moi['id_utilisateur'] == $user['id_utilisateur']);

        //Elle me suit
        $response['user']['following'] =
            (
                app(SuiviPar::class)
                    ->estSuiviPar(
                        $moi['id_utilisateur'],
                        $best['id_utilisateur_fk']
                    ) != null
            );

        //Je la suis
        $response['user']['follower'] = (
            app(SuiviPar::class)
                ->estSuiviPar(
                    $best['id_utilisateur_fk'],
                    $moi['id_utilisateur']
                ) != null
        );

        $categorie = $best->categorie();
        $response['category'] = [];
        foreach ($categorie as $enr) {
            $response['category'][] = $enr['mot_cle'];
        }

        $tag = $best->tag();
        $response['tag'] = [];
        foreach ($tag as $enr) {
            $response['tag'][] = $enr['mot_cle'];
        }

        $cashtag = $best->cashtag();
        $response['cashtag'] = [];
        foreach ($cashtag as $enr) {
            $response['cashtag'][] = $enr['mot_cle'];
        }

        $url = $best->url();
        $response['url'] = [];
        foreach ($url as $enr) {
            $response['url'][] = $enr['url'];
        }

        $mention = $best->mention();
        $response['mention'] = [];
        foreach ($mention as $enr) {
            $response['mention'][] = $enr['pseudo'];
        }

        return $response;
    }

    /***
     * @param int $idutilisateur
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function fluxHome(int $idutilisateur, int $limit = 10, int $offset = 0): array
    {
        $select = Best::select(['id_best'])
            ->distinct()
            ->leftJoin('utilisateur', 'utilisateur.id_utilisateur', 'best.id_utilisateur_fk')
            ->leftJoin('suivi_par', 'suivi_par.id_utilisateur_pere', 'utilisateur.id_utilisateur')
            ->leftJoin('best_like_par', 'best_like_par.id_best_fk', 'best.id_best')
            //->whereNull('best_like_par.date_suppression')
            ->where(function ($query) use ($idutilisateur) {
                $query->where('best_like_par.id_utilisateur_fk', $idutilisateur)
                    ->whereNull('best_like_par.date_suppression')
                    ->orWhere('suivi_par.id_utilisateur_fils', $idutilisateur)
                    ->orWhere('best.id_utilisateur_fk', $idutilisateur);
            })
            ->where('best.status', '=', 'publie')
            ->limit($limit)
            ->offset($offset);

        $config = include app()->basePath() . '/config/flux.php';
        foreach ($config['home']['best']['orderBy'] as $order) {
            $select->orderBy($order['field'], $order['order']);
        }
        $ids = $select->get();

        $flux = [];
        foreach ($ids as $enr) {
            if($enr->id_best) {
                $best = Best::find($enr->id_best);
                $flux[] = self::toAPi($best);
            }
        }

        return $flux;
    }

    /***
     * @param int $idutilisateur
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function fluxHomeByDate(int $idutilisateur, int $limit = 10, int $offset = 0): array
    {
        $ids = Best::select(['id_best'])
            ->distinct()
            ->leftJoin('utilisateur', 'utilisateur.id_utilisateur', 'best.id_utilisateur_fk')
            ->leftJoin('suivi_par', 'suivi_par.id_utilisateur_pere', 'utilisateur.id_utilisateur')
            ->leftJoin('best_like_par', 'best_like_par.id_best_fk', 'best.id_best')
            /*->whereNull('best_like_par.date_suppression')
            ->where(function ($query) use ($idutilisateur) {
                $query->where('suivi_par.id_utilisateur_fils', $idutilisateur)
                    ->orWhere('best.id_utilisateur_fk', $idutilisateur)
                    ->orWhere('best.status', '=', 'publie');
            })*/

            ->where(function ($query) use ($idutilisateur) {
                $query->where('best_like_par.id_utilisateur_fk', $idutilisateur)
                    ->whereNull('best_like_par.date_suppression')
                    ->orWhere('suivi_par.id_utilisateur_fils', $idutilisateur)
                    ->orWhere('best.id_utilisateur_fk', $idutilisateur);
            })
            ->where('best.status', '=', 'publie')

            ->limit($limit)
            ->offset($offset)
            ->orderBy('date_publication', 'desc')
            ->get();


        $flux = [];
        foreach ($ids as $enr) {
            if($enr->id_best) {
                $best = Best::find($enr->id_best);
                $flux[] = self::toAPi($best);
            }
        }

        return $flux;
    }

    /**
     * @param int $idbest
     */
    public static function AllMotsCles(int $idbest)
    {
        /**
         * @var Best $best
         */
        $best = Best::find($idbest);
        $response = [];

        if($best) {
            $categorie = $best->categorie();

            foreach ($categorie as $enr) {
                $response[] = $enr['mot_cle'];
            }

            $tag = $best->tag();
            foreach ($tag as $enr) {
                $response[] = $enr['mot_cle'];
            }
        }
        return $response;
    }
}

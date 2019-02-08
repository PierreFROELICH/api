<?php

namespace App\Services;


use App\Models\Best\Best;
use Illuminate\Support\Facades\DB;

class CategorieService
{
//@todo revoir le quote des valeur en passant par le prepare de pdo
//@voir l'utilisation du mergingBinds
    public static function getSelect($subselect, $idutilisateur, $categorie = [], $limit = 10, $offset = 0)
    {

        if(empty($offset)){
            $offset = 0;
        }
        if(empty($limit)){
            $limit = 10;
        }

        //$select2->whereIn('best_tag.mot_cle', $categorie);
        $categorieuote = [];
        $whereTag = '';
        $whereCategorie = '';

        if (!empty($categorie)) {
            foreach ($categorie as $tag) {
                $categorieuote[] = DB::connection()->getPdo()->quote($tag);
            }
            $whereTag = " and best_tag.mot_cle in (" . \implode(",", $categorieuote) . ") ";
            $whereCategorie = " and best_categorie.mot_cle in (" . \implode(",", $categorieuote) . ") ";
        }

        $select = <<< SQL

        select id_best , nb_like,poids , id_utilisateur from (
            select id_best_fk,  sum(poids) as poids from 
            (
              select id_best_fk, ifnull(poids,0)/100 as poids 
              from best_categorie 
              left join utilisateur_tag on utilisateur_tag.mot_cle = best_categorie.mot_cle 
              where id_utilisateur_fk = $idutilisateur  and type = 'calcule'
              $whereCategorie
              union
              select id_best_fk, ifnull(poids,0)/100  as poids 
              from best_tag 
              left join utilisateur_tag on utilisateur_tag.mot_cle = best_tag.mot_cle
              where id_utilisateur_fk=$idutilisateur and type = 'calcule'
              $whereTag 
              
            ) b  
            group by id_best_fk
      ) bb 
      join best on best.id_best = id_best_fk
    -- ici on garde ceux de la selection
      left join utilisateur on id_utilisateur = id_utilisateur_fk
      where best.status = 'publie' -- and id_utilisateur_fk != 2
      $subselect
      order by best.nb_like-datediff(NOW(), 
               best.date_dernier_like) desc ,
               poids desc ,
               celebrite desc,
               best.date_publication desc
      limit $offset,$limit
SQL;
        /*
                $select1 = DB::table('best_categorie')->select([
                    'id_best_fk',
                    'best_categorie.mot_cle',
                    DB::raw('ifnull(poids,0) as poids'),
                ])
                    ->leftJoin('utilisateur_tag', 'utilisateur_tag.mot_cle', 'best_categorie.mot_cle')
                    ->where('id_utilisateur_fk', $idutilisateur)
                    ->where('type', '=','calcule');
                if (!empty($categorie)) {
                    $select1->whereIn('best_categorie.mot_cle', $categorie);
                }


                $select2 = DB::table('best_tag')->select([
                    'id_best_fk',
                    'best_tag.mot_cle',
                    DB::raw('ifnull(poids,0) as poids'),
                ])
                    ->leftJoin('utilisateur_tag', 'utilisateur_tag.mot_cle', 'best_tag.mot_cle')
                    ->where('id_utilisateur_fk', $idutilisateur)
                    ->where('type', '=','calcule');

                if (!empty($categorie)) {
                    $select2->whereIn('best_tag.mot_cle', $categorie);
                }

                $select2->get();

                $select3 = DB::table(DB::raw('('.$select1->toSql() .' union '.$select2->toSql() . ') as b'))
                    ->select([
                        'id_best_fk',
                        DB::raw('sum(poids) as poids'),
                    ])
                    ->mergeBindings($select1)
                    ->mergeBindings($select2)

                    ->groupBy('id_best_fk');

                $select4 = DB::table(DB::raw('('.$select3->toSql() . ') as bb'))
                    ->mergeBindings($select3)

                    ->select(['id_best'])
                    ->join('best', 'id_best', 'id_best_fk')
                    ->leftJoin('utilisateur', 'id_utilisateur', 'id_utilisateur_fk')
                    ->where('best.status', '=','publie');
        ;
                if (!empty($subSelect)) {
                    $select4->whereRaw($subselect);
                }

                $select4->limit($limit)->offset($offset);
                $config = include app()->basePath() . '/config/flux.php';
                foreach ($config['categorie']['best']['orderBy'] as $order) {
                    $select4->orderBy($order['field'], $order['order']);
                }

                echo $select4->toSql();

                $ids = DB::select($select4->toSql());
                */
        $ids = DB::select($select);

        $flux = [];
        foreach ($ids as $enr) {
            $best = Best::find($enr->id_best);
            $flux[] = BestService::toAPi($best);
        }

        return $flux;
    }

    /**
     * @param     $idutilisateur
     * @param     $categorie
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function fluxBestAll($idutilisateur, $categorie, $limit = 10, $offset = 0)
    {
        return self::getSelect('', $idutilisateur, $categorie, $limit, $offset);
    }

    /**
     * @param     $idutilisateur
     * @param     $categorie
     * @param     $latitude
     * @param     $longitide
     * @param     $distance
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function fluxBestAround(
        $idutilisateur,
        $categorie,
        $latitude,
        $longitude,
        $distance,
        $limit = 10,
        $offset = 0
    ) {
        //en km
        /*
           $subselect =
               " AND (6371 * ACOS( COS( RADIANS($latitude) ) * COS( RADIANS( best.latitude ) ) * COS( RADIANS( best.longitude ) - RADIANS($longitude) ) + SIN( RADIANS($latitude) ) * SIN( RADIANS( best.latitude ) ) ) ) <= $distance ";
   */
        //en mettre
        $distance *= 1000;
        $subselect = " AND (6378137 * 2 * ATAN2(SQRT( SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) * SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) + COS(RADIANS($latitude)) * COS(RADIANS(best.latitude)) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2)), SQRT(1 -  SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) * SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) + COS(RADIANS($latitude)) * COS(RADIANS(best.latitude)) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2)))) <= $distance ";

        return self::getSelect($subselect, $idutilisateur, $categorie, $limit, $offset);
    }

    /**
     * @param     $idutilisateur
     * @param     $categorie
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function fluxBestFriends(
        $idutilisateur,
        $categorie,
        $limit = 10,
        $offset = 0
    ) {

        $subselect = " AND (
            best.id_utilisateur_fk in (
            SELECT id_utilisateur_pere from suivi_par where id_utilisateur_fils= $idutilisateur
            )
            OR best.id_utilisateur_fk = $idutilisateur
        ) ";

        return self::getSelect($subselect, $idutilisateur, $categorie, $limit, $offset);
    }

    /**
     * @param     $idutilisateur
     * @param     $categorie
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function fluxBestMy(
        $idutilisateur,
        $categorie,
        $limit = 10,
        $offset = 0
    ) {

        $subselect = " AND (
        best.id_utilisateur_fk = $idutilisateur
        OR
        best.id_best in ( SELECT id_best_fk from best_like_par where date_suppression is null and id_utilisateur_fk = $idutilisateur)
        ) ";

        return self::getSelect($subselect, $idutilisateur, $categorie, $limit, $offset);
    }
}

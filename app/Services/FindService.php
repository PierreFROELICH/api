<?php

namespace App\Services;

use App\Models\Best\Best;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class FindService
 *
 * @package App\Services
 */
class FindService
{
    /**
     * @param     $idutilisateur
     * @param     $mots
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function findBest($idutilisateur, $mots, $limit = 10, $offset = 0)
    {
        return self::getSelect('', $idutilisateur, $mots, $limit, $offset);
    }

    public static function getSelect($subselect, $idutilisateur, $mots = [], $limit = 10, $offset = 0)
    {

        if (empty($offset)) {
            $offset = 0;
        }
        if (empty($limit)) {
            $limit = 10;
        }

        $configPoids = include app()->basePath() . '/config/poids.php';
        $configPoids = $configPoids['find'];

        $configOrder = include app()->basePath() . '/config/flux.php';
        $configOrder = $configOrder['find'];


        $requete = [];
        $count = 0;
        if (!empty($mots)) {


            foreach ($mots as $mot) {

                $categoriequote[] = DB::connection()->getPdo()->quote($mot);
            }
            $whereTag = " and best_tag.mot_cle in (" . \implode(",", $categoriequote) . ") ";
            $whereCategorie = " and best_categorie.mot_cle in (" . \implode(",", $categoriequote) . ") ";

            $sql2 = <<< SQL

        (select id_best_fk ,poids from (
            select id_best_fk,  sum(poids) as poids from 
            (
              select id_best_fk, ifnull(poids,0)/100 as poids 
              from best_categorie 
              left join utilisateur_tag on utilisateur_tag.mot_cle = best_categorie.mot_cle 
              where -- id_utilisateur_fk = $idutilisateur   and 
                    type = 'calcule'
              $whereCategorie
              union
              select id_best_fk, ifnull(poids,0)/100  as poids 
              from best_tag 
              left join utilisateur_tag on utilisateur_tag.mot_cle = best_tag.mot_cle
              where -- id_utilisateur_fk=$idutilisateur and 
               type = 'calcule'
              $whereTag 
              
            ) b  
            
            group by id_best_fk
           ) inter
      ) p 
      
SQL;


            foreach ($mots as $mot) {
                //$motsquote[] = DB::connection()->getPdo()->quote($tag);
                $mot = \strtolower($mot);
                $like = DB::connection()->getPdo()->quote('%' . $mot . '%');
                $value = DB::connection()->getPdo()->quote($mot);


                //on recherche
                //prio 1 : par categorie * 25
                //prio 2 : par mot dans le text * 5
                //prio 2 : par tag * 5
                //prio 3 : nom * 1
                //prio 3 : prenom * 1
                //prio 3 : pseudo * 1


                //liaison calcul de poinds commmun avec  l'utilisateur (flux bybest all)


                $count++;
                $requete[] = "SELECT id_best_fk as id_best,$count as ordre,   
                                 {$configPoids['best']['categorie']}*(length(mot_cle)-LENGTH(REPLACE(lower(mot_cle),
       $value,'')))
                                   / length( $value ) as pertinence ,$value as mot_cle,'categorie' as type
                          from best_categorie
                          where mot_cle like $like
                          ";

                $count++;
                $requete[] = "SELECT id_best,$count as ordre,   
                                 {$configPoids['best']['titre']}*(length(titre)-LENGTH(REPLACE(lower(titre),$value,
       '')))
                                   / length( $value ) as pertinence ,$value as mot_cle,'titre' as type
                          from best
                          where titre like $like";

                $count++;
                $requete[] = "SELECT id_best,$count as ordre,   
                                 {$configPoids['best']['description']}*(length(description)-LENGTH(REPLACE(  
 lower(      description),$value,
       '')))
                                   / length( $value ) as pertinence ,$value as mot_cle,'description' as type
                          from best
                          where description like $like";


                $count++;
                $requete[] = "SELECT id_best,$count as ordre,   
                                 {$configPoids['best']['address']}*(length(address)-LENGTH(REPLACE(lower(address),
       $value,
       '')))
                                   / length( $value ) as pertinence ,$value as mot_cle,'address' as type
                          from best
                          where address like $like";
                $count++;
                $requete[] = "SELECT id_best,$count as ordre,   
                                 {$configPoids['best']['place']}*(length(place)-LENGTH(REPLACE(lower(place),$value,
       '')))
                                   / length( $value ) as pertinence ,$value as mot_cle,'place' as type
                          from best
                          where place like $like";
                $count++;
                $requete[] = "SELECT id_best_fk as id_best,$count as ordre,   
                                 {$configPoids['best']['tag']}*(length(mot_cle)-LENGTH(REPLACE(lower(mot_cle),
       $value,'')))
                                   / length( $value ) as pertinence ,$value as mot_cle,'tag' as type
                          from best_tag
                          where mot_cle like $like";

                $count++;
                $requete[] = "SELECT  id_best, $count as ordre,  
                                 {$configPoids['best']['nom']}*(length(nom)-LENGTH(REPLACE(lower(nom),$value,'')))
                                   / length( $value ) as pertinence ,$value as mot_cle,'nom' as type
                          from best
                          left join utilisateur on utilisateur.id_utilisateur = id_utilisateur_fk
                          where nom like $like";
                $count++;
                $requete[] = "SELECT  id_best,   $count as ordre,
                                 {$configPoids['best']['prenom']}*(length(prenom)-LENGTH(REPLACE(lower(prenom),
       $value,'')))
                                   / length( $value ) as pertinence ,$value as mot_cle,'prenom' as type
                          from best
                          left join utilisateur on utilisateur.id_utilisateur = id_utilisateur_fk
                          where prenom like $like";
                $count++;
                $requete[] = "SELECT  id_best,   $count as ordre,
                                 {$configPoids['best']['pseudo']}*(length(pseudo)-LENGTH(REPLACE(lower(pseudo),
       $value,'')))
                                   / length( $value ) as pertinence ,$value as mot_cle,'pseudo' as type
                          from best
                          left join utilisateur on utilisateur.id_utilisateur = id_utilisateur_fk
                          where pseudo like $like";

            }
        }
        $order = [];
        foreach ($configOrder['best']['orderBy'] as $tri) {
            $order[] = $tri['field'] . ' ' . $tri['order'];
        }

        $sql = "select t.id_best,  sum(pertinence) as pertinence   
         from (";
        $sql .= join(" union ", $requete);
        $sql .= ") t ";
        $sql .= "join best on best.id_best = t.id_best ";
        $sql .= "left join utilisateur on best.id_utilisateur_fk = utilisateur.id_utilisateur ";

        $sql .= "left join $sql2 on p.id_best_fk = t.id_best ";

        $sql .= "where best.status = 'publie' ";
        $sql .= " group by 1";
        $sql .= ' order by ' . implode(',', $order);
        $sql .= " limit $offset,$limit";

        $ids = DB::select($sql);

        Log::info('Resultat recherche :', [
            'mots' => $mots,
            'pertinence' => $ids,
           // 'requete' => $sql,
        ]);
        $flux = [];
        if (!empty($ids)) {
            foreach ($ids as $enr) {
                $best = Best::find($enr->id_best);
                $flux[] = BestService::toAPi($best);
            }
        }

        return $flux;
    }

}

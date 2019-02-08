<?php

namespace App\Services;


use App\Models\MemoCalculPoidsCategorie;
use App\Models\MotCle;
use App\Models\Utilisateur\UtilisateurTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Poids
{
    static function getCategory(int $idutilisateur)
    {
        $config = include app()->basePath() . '/config/poids.php';

        $config = $config['categorie'];

        $select = <<< SQL
select mot_cle,sum(poids) as poids from ( 
-- following
-- les best
select 'following.best.categorie' as type, mot_cle, {$config['following']['calcule']['best']['categorie']} as poids  
from 
best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join suivi_par on suivi_par.id_utilisateur_pere = best.id_utilisateur_fk
where id_utilisateur_fils = $idutilisateur
union
select 'following.best.tag' as type, mot_cle,  {$config['following']['calcule']['best']['tag']} as poids from best_tag
left join best on best.id_best = best_tag.id_best_fk
left join suivi_par on suivi_par.id_utilisateur_pere = best.id_utilisateur_fk
where id_utilisateur_fils = $idutilisateur

-- les top
union
select 'following.top.categorie' as type, mot_cle, {$config['following']['calcule']['top']['categorie']} as poids from top_categorie
left join top on top.id_top = top_categorie.id_top_fk
left join suivi_par on suivi_par.id_utilisateur_pere = top.id_utilisateur_fk
where id_utilisateur_fils = $idutilisateur
union
select 'following.top.tag' as type, mot_cle, {$config['following']['calcule']['top']['tag']} as poids from top_tag
left join top on top.id_top = top_tag.id_top_fk
left join suivi_par on suivi_par.id_utilisateur_pere = top.id_utilisateur_fk
where id_utilisateur_fils = $idutilisateur

-- les best des tops
union
select 'following.top_best.categorie' as type, mot_cle, 1{$config['following']['calcule']['top_best']['categorie']} as poids from 
best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
left join suivi_par on suivi_par.id_utilisateur_pere = top.id_utilisateur_fk
where id_utilisateur_fils = $idutilisateur
union
select 'following.top_best.tag' as type, mot_cle, {$config['following']['calcule']['top_best']['tag']} as poids from best_tag
left join best on best.id_best = best_tag.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
left join suivi_par on suivi_par.id_utilisateur_pere = top.id_utilisateur_fk
where id_utilisateur_fils = $idutilisateur

-- les miens
-- les best
union
select 'user.best.categorie' as type, mot_cle, {$config['user']['calcule']['best']['categorie']} as poids from 
best_categorie
left join best on best.id_best = best_categorie.id_best_fk
where best.id_utilisateur_fk = $idutilisateur
union
select 'user.best.tag' as type, mot_cle, {$config['user']['calcule']['best']['tag']} as poids from best_tag
left join best on best.id_best = best_tag.id_best_fk
where best.id_utilisateur_fk = $idutilisateur
-- les top
union
select 'user.top.categorie' as type, mot_cle, {$config['user']['calcule']['top']['categorie']} as poids from 
top_categorie
left join top on top.id_top = top_categorie.id_top_fk
where top.id_utilisateur_fk = $idutilisateur
union
select 'user.top.tag' as type, mot_cle, {$config['user']['calcule']['top']['tag']} as poids from top_tag
left join top on top.id_top = top_tag.id_top_fk
where top.id_utilisateur_fk = $idutilisateur

-- les best des top
union
select 'user.top_best.categorie' as type, mot_cle, {$config['user']['calcule']['top_best']['categorie']} as poids from 
best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
where top.id_utilisateur_fk = $idutilisateur
union
select 'user.top_best.tag' as type, mot_cle, {$config['user']['calcule']['top_best']['tag']} as poids from 
best_tag
left join best on best.id_best = best_tag.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
where top.id_utilisateur_fk = $idutilisateur

-- mes like
-- les best
union
select 'like.best.categorie' as type, mot_cle, {$config['like']['calcule']['best']['categorie']} as poids from 
best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join best_like_par on best_like_par.id_best_fk = best.id_best
where best_like_par.date_suppression is null and best_like_par.id_utilisateur_fk = $idutilisateur
union
select 'like.best.tag' as type, mot_cle,  {$config['like']['calcule']['best']['tag']} as poids from best_tag
left join best on best.id_best = best_tag.id_best_fk
left join best_like_par on best_like_par.id_best_fk = best.id_best
where best_like_par.date_suppression is null and  best_like_par.id_utilisateur_fk  = $idutilisateur

-- les top
union
select 'like.top.categorie' as type, mot_cle, {$config['like']['calcule']['top']['categorie']} as poids from 
top_categorie
left join top on top.id_top = top_categorie.id_top_fk
left join top_like_par on top_like_par.id_top_fk = top.id_top
where top_like_par.date_suppression is null and  top_like_par.id_utilisateur_fk = $idutilisateur
union
select 'like.top.tag' as type, mot_cle, {$config['like']['calcule']['top']['tag']} as poids  from top_tag
left join top on top.id_top = top_tag.id_top_fk
left join top_like_par on top_like_par.id_top_fk = top.id_top
where top_like_par.date_suppression is null and  top_like_par.id_utilisateur_fk = $idutilisateur

-- les best des tops
union
select 'top.top_best.categorie' as type, mot_cle, {$config['like']['calcule']['top_best']['categorie']} as poids from 
best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
left join top_like_par on top_like_par.id_top_fk = top.id_top
where  top_like_par.date_suppression is null and top_like_par.id_utilisateur_fk = $idutilisateur
union
select 'top.top_best.tag' as type, mot_cle, {$config['like']['calcule']['top_best']['tag']} as poids from best_tag
left join best on best.id_best = best_tag.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
left join top_like_par on top_like_par.id_top_fk = top.id_top
where top_like_par.date_suppression is null and  top_like_par.id_utilisateur_fk = $idutilisateur

-- mes tag utilisateur
union
select 'user.categorie.utilisateur' as type, mot_cle, {$config['user']['utilisateur']} as poids 
from utilisateur_tag
where type = 'utilisateur' and  id_utilisateur_fk = $idutilisateur

) as t 
group by mot_cle 
order by poids desc


        
SQL;
        $max = 0;

        $rows = DB::select($select);
        foreach ($rows as $row) {
            $max += $row->poids;
        }
        foreach ($rows as $row) {
            $row->poids = round($row->poids * 100 / $max);
        }

        return $rows;
    }

    /**
     * @param int $idutilisateur
     */
    public static function calculateCategoryUtilisateur(int $idutilisateur)
    {
        $category = self::getCategory($idutilisateur);

        $agarder = [];
        foreach ($category as $enr) {
            $agarder[] = $enr->mot_cle;
        }
        UtilisateurTag::whereNotIn(
            'mot_cle',
            $agarder
        )
            ->where(
                'id_utilisateur_fk',
                $idutilisateur
            )
            ->where(
                'type',
                'calcule'
            )->delete();


        foreach ($category as $enr) {
            $tag = MotCle::where(
                'libelle',
                $enr->mot_cle
            )->first();

            UtilisateurTag::UpdateOrCreate(
                [
                    'id_utilisateur_fk' => $idutilisateur,
                    'mot_cle' => $enr->mot_cle,
                    'type' => 'calcule',

                ],
                [
                    'id_mot_cle_fk' => $tag['id_mot_cle'] ?? null,
                    'poids' => $enr->poids,
                ]
            );
        }
    }

    public static function getNextToCalculate()
    {
        $select = <<< SQL
select t2.date_modification,t2.id_utilisateur from(
select max(t.date_modification) as date_modification, t.id_utilisateur from ( 

-- following
-- les best
select best_categorie.date_modification,best.id_utilisateur_fk as id_utilisateur  from best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join suivi_par on suivi_par.id_utilisateur_pere = best.id_utilisateur_fk
union
select best_tag.date_modification,best.id_utilisateur_fk as id_utilisateur from best_tag
left join best on best.id_best = best_tag.id_best_fk
left join suivi_par on suivi_par.id_utilisateur_pere = best.id_utilisateur_fk

-- les top
union
select top_categorie.date_modification ,top.id_utilisateur_fk as id_utilisateur from top_categorie
left join top on top.id_top = top_categorie.id_top_fk
left join suivi_par on suivi_par.id_utilisateur_pere = top.id_utilisateur_fk
union
select top_tag.date_modification,top.id_utilisateur_fk as id_utilisateur from top_tag
left join top on top.id_top = top_tag.id_top_fk
left join suivi_par on suivi_par.id_utilisateur_pere = top.id_utilisateur_fk

-- les best des tops
union
select best_categorie.date_modification ,best.id_utilisateur_fk as id_utilisateur from best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
left join suivi_par on suivi_par.id_utilisateur_pere = top.id_utilisateur_fk
union
select best_tag.date_modification,best.id_utilisateur_fk as id_utilisateur from best_tag
left join best on best.id_best = best_tag.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
left join suivi_par on suivi_par.id_utilisateur_pere = top.id_utilisateur_fk

-- les miens
-- les best
union
select best_categorie.date_modification,best.id_utilisateur_fk as id_utilisateur from best_categorie
left join best on best.id_best = best_categorie.id_best_fk
union
select best_tag.date_modification,best.id_utilisateur_fk as id_utilisateur from best_tag
left join best on best.id_best = best_tag.id_best_fk
-- les top
union
select top_categorie.date_modification,top.id_utilisateur_fk as id_utilisateur from top_categorie
left join top on top.id_top = top_categorie.id_top_fk
union
select top_tag.date_modification,top.id_utilisateur_fk as id_utilisateur from top_tag
left join top on top.id_top = top_tag.id_top_fk

-- les best des top
union
select best_categorie.date_modification,best.id_utilisateur_fk as id_utilisateur from best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
union
select best_tag.date_modification,best.id_utilisateur_fk as id_utilisateur from best_tag
left join best on best.id_best = best_tag.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk

-- mes like
-- les best
union
select best_categorie.date_modification,best.id_utilisateur_fk as id_utilisateur from best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join best_like_par on best_like_par.id_best_fk = best.id_best
where best_like_par.date_suppression is null  
union
select best_tag.date_modification,best.id_utilisateur_fk as id_utilisateur from best_tag
left join best on best.id_best = best_tag.id_best_fk
left join best_like_par on best_like_par.id_best_fk = best.id_best
where best_like_par.date_suppression is null  

-- les top
union
select top_categorie.date_modification,top.id_utilisateur_fk as id_utilisateur from top_categorie
left join top on top.id_top = top_categorie.id_top_fk
left join top_like_par on top_like_par.id_top_fk = top.id_top
where top_like_par.date_suppression is null  
union
select top_tag.date_modification,top.id_utilisateur_fk as id_utilisateur from top_tag
left join top on top.id_top = top_tag.id_top_fk
left join top_like_par on top_like_par.id_top_fk = top.id_top
where top_like_par.date_suppression is null  

-- les best des tops
union
select best_categorie.date_modification,best.id_utilisateur_fk as id_utilisateur from best_categorie
left join best on best.id_best = best_categorie.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
left join top_like_par on top_like_par.id_top_fk = top.id_top
where top_like_par.date_suppression is null  
union
select best_tag.date_modification,best.id_utilisateur_fk as id_utilisateur from best_tag
left join best on best.id_best = best_tag.id_best_fk
left join top_best on top_best.id_best_fk = best.id_best
left join top on top.id_top = top_best.id_top_fk
left join top_like_par on top_like_par.id_top_fk = top.id_top
where top_like_par.date_suppression is null  
-- mes tag utilisateur
union
select utilisateur_tag.date_modification,utilisateur_tag.id_utilisateur_fk as id_utilisateur 
from utilisateur_tag
where type = 'utilisateur' 
 
) as t
 where id_utilisateur is not null
 group by id_utilisateur
 order by max(t.date_modification) 
 ) as t2
left join memo_calcul_poids_categorie on memo_calcul_poids_categorie.id_utilisateur = t2.id_utilisateur
 where date_dernier_calcul is null or (date_dernier_calcul < date_modification) and etat <> 'pending'
limit 1

SQL;

        $rows = DB::select($select);
        return $rows ? $rows[0] : null;

    }

    public static function process()
    {

//@todo logger plus
        Log::info("Démarrage du cron ".__CLASS__);
        $duree = 59;
        $pause = 0.2;
        $nbEnregMax = 100;

        $stop = false;
        if ($duree != -1) {
            set_time_limit($duree * 2);
        }

        $depart = microtime(true);
        $processedTasks = 0;
        $tache = null;
        do {
            do {
                try {

                    $toCalculate = Poids::getNextToCalculate();
                    //Log::info('Suivant',[$toCalculate]);
                    if (!empty($toCalculate)) {
                        try {
                            MemoCalculPoidsCategorie::pending($toCalculate->id_utilisateur);

                            Poids::calculateCategoryUtilisateur($toCalculate->id_utilisateur);
                            MemoCalculPoidsCategorie::ok($toCalculate->id_utilisateur);

                        } catch (\Exception $exception) {
                            Log::error(
                                print_r([
                                    'method' => __METHOD__,
                                    'Exception' => [
                                        'code' => $exception->getCode(),
                                        'message' => $exception->getMessage(),
                                        'trace' => $exception->getTraceAsString(),
                                    ],
                                ], true)
                            );
                            if(isset($toCalculate->id_utilisateur)) {
                                MemoCalculPoidsCategorie::waiting($toCalculate->id_utilisateur);
                            }

                        }
                    }
                } catch (\Exception $exception) {
                    Log::error(
                        print_r([
                            'method' => __METHOD__,
                            'Exception' => [
                                'code' => $exception->getCode(),
                                'message' => $exception->getMessage(),
                                'trace' => $exception->getTraceAsString(),
                            ],
                        ], true)
                    );
                    if ($toCalculate) {
                        MemoCalculPoidsCategorie::waiting($toCalculate->id_utilisateur);
                    }
                }
                $processedTasks++;
                if (($duree > 0) && ((microtime(true) - $depart) > $duree)) {
                    $stop = true;
                }
            } while (!$stop && $processedTasks < $nbEnregMax && $tache !== false);

            if ($duree != -1) {
                time_sleep_until(microtime(true) + $pause);
            }
        } while (($duree != -1) && ((microtime(true) - $depart) <= $duree || $duree == 0) && (!$stop));

        Log::info("Fin du cron ".__CLASS__);

    }

}

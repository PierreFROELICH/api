<?php

namespace App\Services;

use App\Models\Utilisateur\Utilisateur;
use Illuminate\Support\Facades\DB;

/**
 * Class FriendService
 *
 * @package App\Services
 */
class ThemeService
{

    /**
     * @param int $idutilisateur
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function fluxTheme(int $idutilisateur, int $limit = 10, int $offset = 0): array
    {
        $select = <<< SQL

select t2.mot_cle, count(*) as weight from 
(
	select mot_cle from utilisateur_tag 
	join  
	(
		select distinct ut2.id_utilisateur_fk id2  
		from utilisateur_tag ut1
		join  utilisateur_tag ut2 on ut1.mot_cle = ut2.mot_cle
		where ut1.id_utilisateur_fk != ut2.id_utilisateur_fk 
			and ut1.type='calcule' and ut2.type='calcule' 
			and ut1.id_utilisateur_fk = $idutilisateur
	
	) t on id2 = utilisateur_tag.id_utilisateur_fk 
	where mot_cle not  in 
	(
		select mot_cle 
		from utilisateur_tag
		where id_utilisateur_fk = $idutilisateur
	)   
) t2
left join
(
	select mot_cle from best_categorie
	union
	select mot_cle from best_tag
) t3 on t3.mot_cle = t2.mot_cle
group by t2.mot_cle
order by weight desc 
limit $offset,$limit
SQL;


        $select2 = <<< SQL2
select id_utilisateur_fk id , mot_cle,sum(nb_like) as nb_like from 
( 

	select distinct id_best,id_utilisateur_fk ,mot_cle ,nb_like from best
	 join 
	(
		select id_best_fk,mot_cle from best_categorie where mot_cle = ?
		union 
		select id_best_fk,mot_cle from best_tag where mot_cle = ?
	) l1 on id_best = id_best_fk
	 union 
	 select distinct id_top,id_utilisateur_fk,mot_cle,nb_like from top
	  join 
	 (
	 	select id_top_fk,mot_cle from top_categorie where mot_cle = ?
		union 
		select id_top_fk,mot_cle from top_tag where mot_cle = ?
	 ) l2 on id_top = id_top_fk
) t  
left join utilisateur on id_utilisateur = id_utilisateur_fk 
 group by id_utilisateur_fk,mot_cle
order by nb_like desc, celebrite- DATEDIFF(NOW(),utilisateur.date_modification)
 limit 1
SQL2;


        $rows = DB::select($select);

        $flux = [];
        if (count($rows) > 0) {
            foreach ($rows as $row) {

                $rowMeilleur = DB::select(
                    $select2,
                    [
                        $row->mot_cle,
                        $row->mot_cle,
                        $row->mot_cle,
                        $row->mot_cle,
                    ]
                );
                if (!empty($rowMeilleur)) {
                    $flux[] = [
                        'theme' => $row->mot_cle,
                        'best_user' => Utilisateur::find($rowMeilleur[0]->id)->toAPi(false),
                    ];
                }
            }
        }

        return $flux;
    }

}

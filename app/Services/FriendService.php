<?php

namespace App\Services;

use App\Models\Utilisateur\Utilisateur;
use Illuminate\Support\Facades\DB;

/**
 * Class FriendService
 *
 * @package App\Services
 */
class FriendService
{

    /**
     * @param int $idutilisateur
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public static function fluxFriend(int $idutilisateur, int $limit = 10, int $offset = 0): array
    {

        $select = <<< SQL
select id2, sum(diff_poids) / count(*) as distance, count(*) as nb from (
select ut1.id_utilisateur_fk id1,ut2.id_utilisateur_fk id2 ,ut1.mot_cle, sum(abs(ut1.poids-ut2.poids)) diff_poids from 
utilisateur_tag ut1
join  utilisateur_tag ut2 on ut1.mot_cle = ut2.mot_cle
where ut1.id_utilisateur_fk != ut2.id_utilisateur_fk 
and ut2.id_utilisateur_fk not in (
	select id_utilisateur_pere from suivi_par where id_utilisateur_fils = $idutilisateur
)
and ut1.type='calcule' and ut2.type='calcule' 
and ut1.id_utilisateur_fk = $idutilisateur
group by ut1.id_utilisateur_fk,ut2.id_utilisateur_fk,ut1.mot_cle
) t
left join utilisateur on t.id2 = utilisateur.id_utilisateur
group by id1,id2
order by distance,nb,(celebrite-DATEDIFF( NOW(),  date_modification)) desc
limit $offset,$limit

SQL;
        $rows = DB::select($select);
        $flux = [];
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $flux[] = Utilisateur::find($row->id2)->toAPi(false);
            }
        }

        return $flux;
    }

}

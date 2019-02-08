<?php

namespace App\Services;

use App\Models\Best\Best;
use App\Models\Best\BestLikePar;
use App\Models\MotCle;
use App\Models\Utilisateur\SuiviPar;
use App\Models\Utilisateur\UtilisateurTag;
use Illuminate\Support\Facades\Auth;

/**
 * Class TagService
 *
 * @package App\Services
 */
class TagService
{

    /**
     * @param int   $idutilisateur
     * @param array $tags
     */
    public static function userSaveTags(int $idutilisateur, $tags = [])
    {
        UtilisateurTag::whereNotIn(
            'mot_cle',
            $tags
        )
            ->where(
                'id_utilisateur_fk',
                $idutilisateur
            )
            ->where(
                'type',
                'utilisateur'
            )->delete();


        foreach ($tags as $motcle) {
            $tag = MotCle::where(
                'libelle',
                $motcle
            )->first();

            UtilisateurTag::UpdateOrCreate(
                [
                    'id_utilisateur_fk' => $idutilisateur,
                    'mot_cle' => $motcle,
                ],
                [
                    'id_mot_cle_fk' => $tag['id_mot_cle'] ?? null,
                    'type' => 'utilisateur',
                ]
            );
        }
    }

}

<?php

namespace App\Helpers;

use App\Models\Utilisateur\Utilisateur;
use Illuminate\Support\Facades\DB;

/**
 * Class CelebriteHelper
 *
 * @package App\Helpers
 */
class CelebriteHelper
{

    /**
     * @param int $idutilisateur
     */
    public static function likeTop(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'likeTop');
    }

    /**
     * @param int $idutilisateur
     */
    public static function dislikeTop(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'dislikeTop');
    }

    /**
     * @param int $idutilisateur
     */
    public static function likeBest(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'likeBest');
    }

    /**
     * @param int $idutilisateur
     */
    public static function dislikeBest(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'dislikeBest');
    }

    /**
     * @param int $idutilisateur
     */
    public static function follow(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'follow');
    }

    /**
     * @param int $idutilisateur
     */
    public static function unfollow(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'unfollow');
    }

    /**
     * @param int $idutilisateur
     */
    public static function publishBest(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'publishBest');
    }

    /**
     * @param int $idutilisateur
     */
    public static function depublishBest(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'depublishBest');
    }

    /**
     * @param int $idutilisateur
     */
    public static function publishTop(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'publishTop');
    }

    /**
     * @param int $idutilisateur
     */
    public static function depublishTop(int $idutilisateur)
    {
        self::manageCelebrite($idutilisateur, 'depublishTop');
    }
    /**
     * @param int    $idutilisateur
     * @param string $type
     */
    protected static function manageCelebrite(int $idutilisateur, string $type)
    {
        $celebrite = include app()->basePath() . '/config/celebrite.php';

        Utilisateur::where('id_utilisateur', $idutilisateur)
            ->update(
                [
                    'celebrite' => DB::raw('celebrite+' . $celebrite[$type] ?:  0),
                ]
            );
    }
}


<?php

namespace App\Models\Utilisateur;

use App\Models\Best\Best;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Utilisateur
 *
 * @package App\Models\Utilisateur
 */
class Utilisateur extends Model
{

    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';
    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */
    protected $table = 'utilisateur';

    /**
     * @var string
     */
    protected $primaryKey = 'id_utilisateur';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'nom',
        'prenom',
        'pseudo',
        'telephone',
        'latitude',
        'longitude',
        'address',
        'place',
        'mdp',
        'date_mdp',
        'token_session',
        'debut_session',
        'token_mdp_oublie',
        'date_mdp_oublie',
        'guid',
        'date_guid',
        'date_creation',
        'date_modification',
        'date_suppression',
        'date_validation_cgu',
        'version_cgu',
        'url_image',
    ];

    protected $hidden = [
        'id_utilisateur',
        'mdp',
        'date_mdp',
        'token_session',
        'debut_session',
        'token_mdp_oublie',
        'date_mdp_oublie',
        'date_guid',
        'date_creation',
        'date_modification',
        'date_suppression',
        'date_validation_cgu',
        'version_cgu',
    ];


    /**
     * @param $idfils
     * @param $limit
     * @param $offset
     *
     * @return mixed
     */
    public static function getFollowing($idfils, $limit, $offset,$idme)
    {
        return self::selectFollowing($idfils)
            ->select(
                [
                    'pseudo as username',
                    'nom as lastName',
                    'prenom as firstName',
                    'status',
                    'celebrite',
                    DB::raw('
                (select exists (select * from suivi_par as b where b.id_utilisateur_pere = ' . $idme .
                        ' and b.id_utilisateur_fils = a.id_utilisateur_pere)) as following'
                    ),
                    DB::raw(
                        '(select exists(select * from suivi_par as c where c.id_utilisateur_fils = ' . $idme .
                        ' and c.id_utilisateur_pere = a.id_utilisateur_pere)) as follower'
                    ),
                ]

            )
            ->limit($limit)
            ->offset($offset)
            ->orderBy('pseudo')
            ->get();
    }

    /**
     * @param $idfils
     * @param $limit
     * @param $offset
     *
     * @return mixed
     */
    protected static function selectFollowing($idfils)
    {
        return DB::table('suivi_par as a')
            ->leftJoin('utilisateur', 'id_utilisateur', 'id_utilisateur_pere')
            ->where(
                'id_utilisateur_fils',
                $idfils
            )
            ->whereIn(
                'status',
                [
                    'en_attente_validation',
                    'certifie',

                ]
            )
            ->whereNull('utilisateur.date_suppression');
    }

    /**
     * @param $idfils
     * @param $limit
     * @param $offset
     *
     * @return mixed
     */
    public static function getCountFollowing($idfils)
    {
        return self::selectFollowing($idfils)->count();
    }

    /**
     * @param $idfils
     * @param $limit
     * @param $offset
     *
     * @return mixed
     */
    public static function getFollower(int $idpere, int $limit, int $offset, int $idme)
    {
        return self::selectFollower($idpere)
            ->select(
                [
                    'pseudo as username',
                    'nom as lastName',
                    'prenom as firstName',
                    'status',
                    'celebrite',

                    DB::raw('
                (select exists (select * from suivi_par as b where b.id_utilisateur_pere = ' . $idme .
                        ' and b.id_utilisateur_fils = a.id_utilisateur_fils)) as following'
                    ),
                    DB::raw(
                        '(select exists(select * from suivi_par as c where c.id_utilisateur_fils = ' . $idme .
                        ' and c.id_utilisateur_pere = a.id_utilisateur_fils)) as follower'
                    ),
                ]

            )
            ->limit($limit)
            ->offset($offset)
            ->orderBy('pseudo')
            ->get();
    }

    /**
     * @param $idpere
     * @param $limit
     * @param $offset
     *
     * @return mixed
     */
    protected static function selectFollower($idpere)
    {
        return DB::table('suivi_par as a')
            ->leftJoin('utilisateur', 'id_utilisateur', 'id_utilisateur_fils')
            ->where(
                'id_utilisateur_pere',
                $idpere
            )
            ->whereIn(
                'status',
                [
                    'en_attente_validation',
                    'certifie',

                ]
            )
            ->whereNull('utilisateur.date_suppression');
    }

    /**
     * @param $idpere
     * @param $limit
     * @param $offset
     *
     * @return mixed
     */
    public static function getCountFollower($idpere)
    {
        return self::selectFollower($idpere)->count();
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * @param bool $all
     *
     * @return array
     */
    public function toAPi(bool $all = true): array
    {
        if ($all) {
            return [
                'username' => $this->attributes['pseudo'],
                'firstName' => $this->attributes['prenom'],
                'lastName' => $this->attributes['nom'],
                'email' => $this->attributes['email'],
                'phone' => $this->attributes['telephone'],
                'userStatus' => $this->attributes['status'],
                'celebrity' => $this->attributes['celebrite'],
                'guid' => $this->attributes['guid'],
                'latitude' => $this->attributes['latitude'],
                'longitude' => $this->attributes['longitude'],
                'address' => $this->attributes['address'],
                'place' => $this->attributes['place'],
                'url_image' =>  env('DEPOT_URL_AVATAR_PUBLIC').$this->attributes['url_image'],
                'tags' => UtilisateurTag::tags($this->attributes['id_utilisateur']),
                'best' => Best::count($this->attributes['id_utilisateur'])    ,

            ];
        }

        return [
            'username' => $this->attributes['pseudo'],
            'firstName' => $this->attributes['prenom'],
            'lastName' => $this->attributes['nom'],
            'userStatus' => $this->attributes['status'],
            'celebrity' => $this->attributes['celebrite'],
            'latitude' => $this->attributes['latitude'],
            'longitude' => $this->attributes['longitude'],
            'address' => $this->attributes['address'],
            'place' => $this->attributes['place'],
            'url_image' =>  env('DEPOT_URL_AVATAR_PUBLIC').$this->attributes['url_image'],
            'tags' => UtilisateurTag::tags($this->attributes['id_utilisateur']),
            'best' => Best::count($this->attributes['id_utilisateur'])    ,

        ];
    }
}

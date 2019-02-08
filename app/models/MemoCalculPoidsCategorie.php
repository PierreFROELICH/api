<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class MotCle
 *
 * @package App\Models
 */
class MemoCalculPoidsCategorie extends Model
{


    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'memo_calcul_poids_categorie';

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
        'id_utilisateur',
        'etat',
        'date_dernier_calcul',
    ];

    protected $hidden = [
    ];

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * @param int $idutilisateur
     */
    public static function waiting(int $idutilisateur)
    {
        DB::transaction(function () use ($idutilisateur) {
            MemoCalculPoidsCategorie::UpdateOrCreate(
                [
                    'id_utilisateur' => $idutilisateur,
                ],
                [
                    'etat' => 'waiting',
                ]
            );
        });
    }

    /**
     * @param $idutilisateur
     */
    public static function  pending($idutilisateur)
    {
        DB::transaction(function () use ($idutilisateur) {
            MemoCalculPoidsCategorie::UpdateOrCreate(
                [
                    'id_utilisateur' => $idutilisateur,
                ],
                [
                    'etat' => 'pending',
                ]
            );
        });
    }

    public static function ok($idutilisateur)
    {
        DB::transaction(function () use ($idutilisateur) {
            MemoCalculPoidsCategorie::UpdateOrCreate(
                [
                    'id_utilisateur' => $idutilisateur,
                ],
                [
                    'etat' => 'ok',
                    'date_dernier_calcul' => Carbon::now(),
                ]
            );
        });
    }
}


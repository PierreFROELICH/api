<?php

namespace App\Models\Best;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BestLikePar
 *
 * @package App\Models\Best
 */
class BestLikePar extends Model
{

    use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;

    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';
    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * @var string
     */
    protected $table = 'best_like_par';

    /**
     * @var string
     */
    protected $primaryKey = [
        'id_utilisateur_fk',
        'id_best_fk',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_utilisateur_fk',
        'id_best_fk',
        'date_creation',
        'date_modification',
        'date_suppression',
    ];

    protected $hidden = [
        'id_utilisateur_fk',
        'id_best_fk',
    ];


    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * @param int $idpere
     * @param int $idfils
     *
     * @return mixed
     */
    public function estLikePar(int $idutilisateur,int $idbest){
        return $this->where(
            'id_utilisateur_fk',
            $idutilisateur
        )->where(
            'id_best_fk',
            $idbest
        )->whereNull(
            'date_suppression'
        )->first();

    }

}

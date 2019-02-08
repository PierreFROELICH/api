<?php

namespace App\Models\Utilisateur;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SuiviPar
 *
 * @package App\Models\Utilisateur
 */
class SuiviPar extends Model
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
    protected $table = 'suivi_par';

    /**
     * @var string
     */
    protected $primaryKey = [
        'id_utilisateur_pere',
        'id_utilisateur_fils',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_utilisateur_pere',
        'id_utilisateur_fils',
        'date_creation',
        'date_modification',
        'date_suppression',
    ];

    protected $hidden = [
        'id_utilisateur_pere',
        'id_utilisateur_fils',
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
    public function estSuiviPar(int $idpere,int $idfils){
        return $this->where(
                'id_utilisateur_pere',
                $idpere
        )->where(
            'id_utilisateur_fils',
            $idfils
        )->first();

    }

    public static function transform($liste)
    {
        $retour = [];
        foreach ($liste as $i => $item) {
            $retour[$i] = (array)($item);
            $retour[$i]['follower'] = $retour[$i]['follower'] == 1;
            $retour[$i]['following'] = $retour[$i]['following'] == 1;
        }
        return $retour;
    }


}

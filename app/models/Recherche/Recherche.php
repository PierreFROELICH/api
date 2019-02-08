<?php

namespace App\Models\Recherche;

use App\Models\Utilisateur\Utilisateur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Best
 *
 * @package App\Models\Best
 */
class Recherche extends Model
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
    protected $table = 'recherche';

    /**
     * @var string
     */
    protected $primaryKey = 'id_recherche';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'q',
        'id_utilisateur_fk',
    ];

    protected $hidden = [
        'id_utilisateur_fk',
        'date_creation',
        'date_modification',
    ];

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tag()
    {
        return RechercheTag::where(
            'id_recherche_fk',
            $this->attributes['id_recherche']
        )->orderBy('mot_cle')->get();
    }


    /**
     * @return mixed
     */
    public function utilisateur()
    {
        return Utilisateur::where('id_utilisateur',$this->attributes['id_utilisateur_fk'])->first();
    }

}

<?php

namespace App\Models\Best;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BestUtilisateur
 *
 * @package App\Models\Best
 */
class BestUtilisateur extends Model
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
    protected $table = 'best_utilisateur';

    /**
     * @var string
     */
    protected $primaryKey = 'id_best_utilisateur';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_best_fk',
        'id_utilisateur_fk',
        'pseudo',
    ];

    protected $hidden = [
        'id_best_fk',
        'id_best_utilisateur',
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

}

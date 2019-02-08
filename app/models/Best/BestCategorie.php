<?php

namespace App\Models\Best;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BestCategorie
 *
 * @package App\Models\Best
 */
class BestCategorie extends Model
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
    protected $table = 'best_categorie';

    /**
     * @var string
     */
    protected $primaryKey = 'id_best_categorie';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_best_fk',
        'id_mot_cle_fk',
        'mot_cle',
    ];

    protected $hidden = [
        'id_best_fk',
        'id_best_categorie',
        'id_mot_cle_fk',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MotCle
 *
 * @package App\Models
 */
class MotCle extends Model
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
    protected $table = 'mot_cle';

    /**
     * @var string
     */
    protected $primaryKey = 'id_mot_cle';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_utilisateur_fk',
        'id_tag_fk',
        'id_langue_fk',
        'libelle',
    ];

    protected $hidden = [
        'id_mot_cle',
        'id_utilisateur_fk',
        'id_tag_fk',
        'id_langue_fk',
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

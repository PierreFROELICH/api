<?php

namespace App\Models\Top;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TopLikePar
 *
 * @package App\Models\Top
 */
class TopLikePar extends Model
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
    protected $table = 'top_like_par';

    /**
     * @var string
     */
    protected $primaryKey = [
        'id_utilisateur_fk',
        'id_top_fk',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_utilisateur_fk',
        'id_top_fk',
        'date_creation',
        'date_modification',
        'date_suppression',
    ];

    protected $hidden = [
        'id_utilisateur_fk',
        'id_top_fk',
    ];


    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }


}

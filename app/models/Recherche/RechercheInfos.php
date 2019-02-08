<?php

namespace App\Models\Recherche;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RechercheInfos
 *
 * @package App\Models\Recherche
 */

class RechercheInfos extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'recherche_infos';

    /**
     * @var string
     */
    protected $primaryKey = 'id_recherche_infos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_recherche_fk',
        'date_recherche',
        'offset',
        'limit',
    ];

    protected $hidden = [
        'id_recherche_fk',
        'id_recherche_infos',
        ];

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

}

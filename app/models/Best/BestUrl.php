<?php

namespace App\Models\Best;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BestUrl
 *
 * @package App\Models\Best
 */
class BestUrl extends Model
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
    protected $table = 'best_url';

    /**
     * @var string
     */
    protected $primaryKey = 'id_best_url';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_best_fk',
        'url',
    ];

    protected $hidden = [
        'id_best_fk',
        'id_best_url',
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

<?php

namespace App\Models\Top;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Top
 *
 * @package App\Models\Top
 */
class Top extends Model
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
    protected $table = 'top';

    /**
     * @var string
     */
    protected $primaryKey = 'id_top';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'nb_like',
        'latitude',
        'longitude',
        'date_dernier_like',
        'id_utilisateur_fk',
        'date_dernier_like',
        'date_publication',
        'date_suppression',
    ];

    protected $hidden = [
        'date_creation',
        'date_modification',
        'date_suppression',
    ];

    public static function majCompteur($idtop)
    {

        $row = DB::table('top_like_par')->where(
            'id_top_fk',
            $idtop
        )->whereNull(
            'date_suppression'
        )->select(
            [
                DB::raw('max(date_creation) as date_dernier_like'),
                DB::raw('count(1) as count'),
            ]
        )->first();

        self::where(
            'id_top',
            $idtop

        )->update(
            [
                'nb_like' => $row->count ?? 0,
                'date_dernier_like' => $row->date_dernier_like ?? null,
            ]
        );

        return $row->count ?? 0;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }
}

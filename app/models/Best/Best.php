<?php

namespace App\Models\Best;

use App\Models\Utilisateur\Utilisateur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Best
 *
 * @package App\Models\Best
 */
class Best extends Model
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
    protected $table = 'best';

    /**
     * @var string
     */
    protected $primaryKey = 'id_best';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'titre',
        'description',
        'url_image',
        'nb_like',
        'latitude',
        'longitude',
        'address',
        'place',
        'date_dernier_like',
        'id_utilisateur_fk',
        'status',
        'date_publication',
        'date_suppression'
    ];

    protected $hidden = [
        'id_utilisateur_fk',
        'date_creation',
        'date_modification',

    ];

    public static function majCompteur($idbest)
    {

        $row = DB::table('best_like_par')->where(
            'id_best_fk',
            $idbest
        )->
        whereNull(
            'date_suppression'
        )->select(
            [
                DB::raw('max(date_creation) as date_dernier_like'),
                DB::raw('count(1) as count'),
            ]
        )
            ->first();

        self::where(
            'id_best',
            $idbest

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cashtag()
    {
        return BestCashtag::where(
            'id_best_fk',
            $this->attributes['id_best']
        )->orderBy('mot_cle')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categorie()
    {
        return BestCategorie::where(
            'id_best_fk',
            $this->attributes['id_best']
        )->orderBy('mot_cle')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tag()
    {
        return BestTag::where(
            'id_best_fk',
            $this->attributes['id_best']
        )->orderBy('mot_cle')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function url()
    {
        return BestUrl::where(
            'id_best_fk',
            $this->attributes['id_best']
        )->orderBy('url')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mention()
    {
        return BestUtilisateur::where(
            'id_best_fk',
            $this->attributes['id_best']
        )->orderBy('pseudo')->get();
    }

    /**
     * @return mixed
     */
    public function utilisateur()
    {
        return Utilisateur::where('id_utilisateur',$this->attributes['id_utilisateur_fk'])->first();
    }

    public function toAPi(){
        return [
            'idBest' => $this->attributes['id_best'],
            'type' =>$this->attributes['type'],
            'title' =>$this->attributes['titre'],
            'description' => $this->attributes['description'],
            'url_image' =>
                \file_exists(storage_path(env('DEPOT_IMAGE_TEMP')).$this->attributes['url_image'])
                    ? env('DEPOT_URL_IMAGE_PUBLIC').$this->attributes['url_image']
                    : $this->attributes['url_image'],
            'like' => $this->attributes['nb_like'],
            'latitude' => $this->attributes['latitude'],
            'longitude' => $this->attributes['longitude'],
            'address' => $this->attributes['address'],
            'place' => $this->attributes['place'],
            'last_like_date' => $this->attributes['date_dernier_like'],
            'published' => $this->attributes['status'] == 'publie',
            'publication_date' => $this->attributes['date_publication'],
        ];
    }

    public static function count($idutilisateur){
        return self::where('id_utilisateur_fk',$idutilisateur)->where('status','publie')->count();
    }
}

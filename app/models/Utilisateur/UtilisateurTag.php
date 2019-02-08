<?php

namespace App\Models\Utilisateur;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UtilisateurTag
 *
 * @package App\Models\Utilisateur
 */
class UtilisateurTag extends Model
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
    protected $table = 'utilisateur_tag';

    /**
     * @var string
     */
    protected $primaryKey = 'id_utilisateur_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_utilisateur_fk',
        'id_mot_cle_fk',
        'mot_cle',
        'type',
        'poids',
    ];

    protected $hidden = [
        'id_utilisateur_fk',
        'id_utilisateur_tag',
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

    public function toApi()
    {
        return [
            'tag' => $this->attributes['mot_cle'],
            'weight' => $this->attributes['poids'],
            'type' => $this->attributes['type'],
        ];

    }

    public static function tags(int $idutilisateur)
    {
        $tags = UtilisateurTag::where(
            'id_utilisateur_fk',
            $idutilisateur
        )
            ->orderBy('type')
            ->orderBy('poids','desc')
            ->get();

        $toApi = [];
        foreach ($tags as $tag) {
            $toApi[] = $tag->toAPi();
        }

        return $toApi;
    }
}

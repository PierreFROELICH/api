<?php

namespace App\Models\Utilisateur;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Utilisateur
 *
 * @package App\Models\UtilisateurAuh
 */
class UtilisateurAuth extends Model
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
    protected $table = 'utilisateur_auth';

    /**
     * @var string
     */
    protected $primaryKey = 'id_utilisateur_auth';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token_session',
        'debut_session',
        'guid',
        'ip',
        'useragent',
        'id_utilisateur_fk',
        'date_creation',
        'date_modification',

    ];

    protected $hidden = [
        'id_utilisateur_auth',
        'token_session',
        'debut_session',
    ];

    /**
     * @param string|null $guid
     * @param string|null $token
     *
     * @return \App\Models\Utilisateur\Utilisateur |null
     */
    public static function checkLogin(string $guid = null, string $token = null)
    {
        $utilisateurAuth = self::where(
            'token_session',
            $token
        )
            ->where(
                'guid',
                $guid
            )
            ->whereRaw(
                'DATE_ADD(debut_session, INTERVAL ' . env('AUTH_SESSION_MAX_LIFETIME') . ' MINUTE) >= ?',
                date('Y-m-d H:m:d')
            )->first();

        if ($utilisateurAuth) {

            return Utilisateur::whereIn(
                'status',
                [
                    'en_attente_validation',
                    'certifie',

                ]
            )
                ->whereNull('date_suppression')
                ->where('id_utilisateur', '=', $utilisateurAuth['id_utilisateur_fk'])
                ->first();
        }

        return null;
    }

}

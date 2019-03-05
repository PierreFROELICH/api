<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\CelebriteHelper;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Api\ApiController;
use App\Models\MotCle;
use App\Models\Utilisateur\SuiviPar;
use App\Models\Utilisateur\Utilisateur;
use App\Models\Utilisateur\UtilisateurAuth;
use App\Models\Utilisateur\UtilisateurTag;
use App\Services\Registry;
use App\Services\TagService;
use Dingo\Api\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

//@todo: choix de la langue à la creation
//@todo: controle que la creation du mdp est OK
//@todo: modifier le forcage de la validation des cgu
//@todo : process de modification de l'emil et du mdp. pseudo non modifiable

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api\V1
 */
class UserController extends ApiController
{
    /**
     *
     */
    public function index()
    {
        $this->response->errorBadRequest();
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function login(Request $request)
    {
        /**
         * @var Utilisateur $user
         */
        $user = Utilisateur::where(function ($query) use ($request) {

            $query->where('email',
                $request->input('username')
            )
                ->orWhere('pseudo',
                    $request->input('username')
                );
        })
            ->whereIn(
                'status',
                [
                    'en_attente_validation',
                    'certifie',

                ]
            )
            ->whereNull('date_suppression')
            ->first();

        if ($user) {
            if (\password_verify($request->input('password'), $user->mdp)) {
                //mettre a jour le token et la date de debut de session

                $token = bin2hex(random_bytes(32));

                UtilisateurAuth::create(
                    [
                        'guid' => $user['guid'],
                        'id_utilisateur_fk' => $user['id_utilisateur'],
                        'token_session' => $token,
                        'debut_session' => Carbon::now(),
                        'ip' => $request->ip(),
                        'useragent' => $request->header('User-Agent'),
                    ]
                );

                return $this->response
                    ->array(
                        $user->toApi()
                    )
                    ->withHeader('X-Token', $token);
            }
        }
        $this->response->errorBadRequest('Invalid username/password supplied');

    }


    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return mixed
     * @throws \ErrorException
     */
    public function checkLogin(Request $request)
    {
        /**
         * @var Utilisateur $user
         */
        $user = UtilisateurAuth::checkLogin($request->header('guid'), $request->header('token'));

        if ($user) {
            return $this->response
                ->array(
                    $user->toApi()
                );
        }

        $this->response->errorUnauthorized('Invalid guid/token supplied');

    }

    /**
     * @param \Dingo\Api\Http\Request $request
     */
    public function logout(Request $request)
    {
        /**
         * @var Utilisateur $user
         */
        UtilisateurAuth::where(
            'guid',
            $request->header('guid')
        )
            ->where(
                'token_session',
                $request->header('token')
            )
            ->delete();

    }

    /**
     * @param string $username
     *
     * @return mixed
     * @throws \ErrorException
     */
    public function getUser(string $username)
    {
        /**
         * @var Utilisateur $user
         */

        $moi = Auth::user();
        $user = Registry::get('route_username');
        $toApi = $user->toApi($moi['id_utilisateur'] == $user['id_utilisateur']);

        //Elle me suit
        $toApi['following'] = (app(SuiviPar::class)->estSuiviPar($moi['id_utilisateur'], $user['id_utilisateur']) !=
            null);

        //Je la suis
        $toApi['follower'] = (app(SuiviPar::class)->estSuiviPar($user['id_utilisateur'], $moi['id_utilisateur']) !=
            null);

        return $this->response()
            ->array(
                $toApi
            );

    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        //@todo : refactoriser ftp
        $name = $request->input('url');
        if ($request->file('avatar')->isValid() && $request->hasFile('avatar')) {

            $name = bin2hex(random_bytes(32)).'.'.$extension;

            //@todo : on pose le fichier sur le ftp
            if (env('DEPOT_IMAGE_DRIVER')) {
                //faire le depot du fichier
                $request->file('avatar')->move(DEPOT_AVATAR_REP)
                /*Config::set(
                    'filesystems.disks.depot_image',
                    Config::get('depot.image')
                );

                if (Storage::disk('depot_image')
                    ->exists(
                        env('DEPOT_AVATAR_REP') . "/" . $name
                    )
                ) {
                    Storage::disk('depot_image')
                        ->delete(
                            env('DEPOT_AVATAR_REP') . "/" . $name
                        );

                }

                Storage::disk('depot_image')
                    ->put(
                        env('DEPOT_AVATAR_REP') . "/" . $name,

                        \file_get_contents($file)
                    );*/


            }

        }

        $user = Utilisateur::create(
            [
                'email' => $request->input('email'),
                'nom' => $request->input('lastName'),
                'prenom' => $request->input('firstName'),
                'pseudo' => $request->input('username'),
                'telephone' => $request->input('phone'),
                'mdp' => \password_hash($request->input('password'), PASSWORD_BCRYPT),
                'date_mdp' => Carbon::now(),
                'guid' => DB::raw('UUID()'),
                'date_guid' => Carbon::now(),
                'id_langue_fk' => 1,
                'status' => 'en_attente_validation',
                'celebrite' => 1,
                'date_validation_cgu' => Carbon::now(),
                'version_cgu' => 1,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'address' => $request->input('address'),
                'place' => $request->input('place'),

                'url_image' => $name,
            ]
        );

        $tags = $request->input('tags');

        if(!empty($tags)) {
            TagService::userSaveTags($user['id_utilisateur'], $tags);
        }

        return $this->response->created(null, ['username' => $request->input('username')]);
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @throws \Exception
     */
    public function update(Request $request)
    {

        $name = $request->input('url');
        if ($request->has('file') && !empty($request->input('file'))) {

            $name = ImageHelper::saveFromBase64($request->input('file'), 'DEPOT_AVATAR_TEMP');
            $file = storage_path(env('DEPOT_IMAGE_TEMP')) . '/' . $name;

            //@todo : on pose le fichier sur le ftp
            if (env('DEPOT_IMAGE_DRIVER')) {
                //faire le depot du fichier
                Config::set(
                    'filesystems.disks.depot_image',
                    Config::get('depot.image')
                );

                if (Storage::disk('depot_image')
                    ->exists(
                        env('DEPOT_AVATAR_REP') . "/" . $name
                    )
                ) {
                    Storage::disk('depot_image')
                        ->delete(
                            env('DEPOT_AVATAR_REP') . "/" . $name
                        );

                }
                Storage::disk('depot_image')
                    ->put(
                        env('DEPOT_AVATAR_REP') . "/" . $name,

                        \file_get_contents($file)
                    );
            }
        }

        $array = [
            'nom' => 'lastName',
            'prenom' => 'firstName',
            'telephone' => 'phone',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'address' => 'address',
            'place' => 'place',
        ];

        $update = [];
        if (!empty($name)) {
            $update['url_image'] = $name;
        }

        foreach ($array as $field => $name) {
            if ($request->has($name)) {
                $update[$field] = $request->input($name);
            }
        }


        if (!empty($array)) {
            Utilisateur::where(
                'token_session',
                $request->header('token')
            )
                ->where(
                    'guid',
                    $request->header('guid')
                )
                ->update($update);
        };

    }

    public function setOptions()
    {
        return $this->response->created();
    }

    /**
     * @param string $username
     *
     * @return \Dingo\Api\Http\Response
     */
    public function follow(string $username)
    {
        $user = Auth::user();
        $follow = Registry::get('route_username');
        if ($user['id_utilisateur'] != $follow['id_utilisateur']) {
            if (count(SuiviPar::where(
                    'id_utilisateur_pere',
                    $follow['id_utilisateur']
                )->where(
                    'id_utilisateur_fils', $user['id_utilisateur'])->get()) == 0) {
                SuiviPar::UpdateOrCreate(
                    [
                        'id_utilisateur_pere' => $follow['id_utilisateur'],
                        'id_utilisateur_fils' => $user['id_utilisateur'],
                    ],
                    []
                );
                CelebriteHelper::follow($follow['id_utilisateur']);
            }
        }

        return $this->response->created();
    }

    /**
     * @param string $username
     */
    public function unfollow(string $username)
    {
        $user = Auth::user();
        $follow = Registry::get('route_username');

        $suiviPar = SuiviPar::where(
            'id_utilisateur_pere',
            $follow['id_utilisateur']
        )->where(
            'id_utilisateur_fils', $user['id_utilisateur']
        )->get();

        if (count($suiviPar)) {
            $suiviPar->each->delete();
            CelebriteHelper::unfollow($follow['id_utilisateur']);
        }
    }

    /**
     * @param \Dingo\Api\Http\Request $reuest
     */
    public function saveTags(Request $request)
    {
        $user = Auth::user();

        $tags = Registry::get('request_json')['tags'];

        TagService::userSaveTags($user['id_utilisateur'],$tags);

        return $this->response->noContent();
    }

    /**
     * @param string $username
     *
     * @return mixed
     */
    public function getTags(string $username)
    {
        $user = Registry::get('route_username');
        $tags = UtilisateurTag::where(
            'id_utilisateur_fk',
            $user['id_utilisateur']
        )->get();

        $toApi = [];
        foreach ($tags as $tag) {
            $toApi[] = $tag->toAPi();
        }

        return $toApi;


    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\CelebriteHelper;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Api\ApiController;
use App\Models\Best\Best;
use App\Models\Best\BestCashtag;
use App\Models\Best\BestCategorie;
use App\Models\Best\BestLikePar;
use App\Models\Best\BestTag;
use App\Models\Best\BestUrl;
use App\Models\Best\BestUtilisateur;
use App\Models\MotCle;
use App\Models\Utilisateur\Utilisateur;
use App\Services\BestService;
use App\Services\Registry;
use Dingo\Api\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


/**
 * Class BestController
 *
 * @package App\Http\Controllers\Api\V1
 */
class BestController extends ApiController
{

    /**
     *
     */
    public function index()
    {
        $this->response->errorBadRequest();
    }

    //@todo : verifier que le best modifié ou supprimé appartient à l'utilisateur loggué

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @throws \Exception
     */
    public function create(Request $request)
    {

        //@todo factoriser le trasfert ftp
        //@todo faire un cron qui transfert les fichier stocké depuis plus 1 minutes
        $user = Auth::user();
        $name = $request->input('url');
        if ($request->has('file') && !empty($request->input('file'))) {

            $name = ImageHelper::saveFromBase64($request->input('file'),'DEPOT_IMAGE_TEMP');
            $file = storage_path(env('DEPOT_IMAGE_TEMP')).'/'.$name;

            //@todo : on pose le fichier sur le ftp
            if (env('DEPOT_IMAGE_DRIVER')) {
                //faire le depot du fichier
                Config::set(
                    'filesystems.disks.depot_image',
                    Config::get('depot.image')
                );

                if (Storage::disk('depot_image')
                    ->exists(
                        env('DEPOT_IMAGE_REP') . "/" . $name
                    )
                ) {
                    Storage::disk('depot_image')
                        ->delete(
                            env('DEPOT_IMAGE_REP') . "/" . $name
                        );

                }

                Storage::disk('depot_image')
                    ->put(
                        env('DEPOT_IMAGE_REP') . "/" . $name,

                        \file_get_contents($file)
                    );


            }

        }

        //on enregistre le best
        $status = 'brouillon';
        $datepublication = null;
        if ($request->input('status') == 'to_publish') {
            $status = 'publie';
            $datepublication = Carbon::now();
        }

        $best = Best::create(
            [
                'type'=> $request->input('type','photo'),
                'titre' => $request->input('title'),
                'description' => $request->input('description'),
                'url_image' => $name,
                'nb_like' => 0,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'address' => $request->input('address'),
                'place' => $request->input('place'),
                'date_dernier_like' => null,
                'id_utilisateur_fk' => $user['id_utilisateur'],
                'status' => $status,
                'date_publication' => $datepublication,
            ]
        );


        $this->saveCategory(
            $request->input('category'),
            $best['id_best']
        );


        //on extract les elemnts (tag,... ) des titre et description
        $extractTitle = \Twitter\Text\Extractor::create()
            ->extract($request->input('title'));
        $extractDescription = \Twitter\Text\Extractor::create()
            ->extract($request->input('description'));

        $tags = array_merge(
            $extractTitle['hashtags'],
            $extractDescription['hashtags']
        );

        $this->saveTags($tags, $best['id_best']);

        $cashtags = array_merge(
            $extractTitle['cashtags'],
            $extractDescription['cashtags']
        );

        $this->saveCashtags($cashtags, $best['id_best']);

        $urls = array_merge(
            $extractTitle['urls'],
            $extractDescription['urls']
        );

        $this->saveUrl($urls, $best['id_best']);

        $utilisateurs = array_merge(
            $extractTitle['mentions'],
            $extractDescription['mentions']
        );

        $this->saveUtilisateurs($utilisateurs, $best['id_best']);

        if ($status == 'publie') {
            CelebriteHelper::publishBest($user['id_utilisateur']);
        }

        // on retoune l'id du best
        return $this->response->created(
            null,
            //$best['id_best']
            BestService::toAPi($best)
        );
    }


    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @throws \Exception
     */
    public function update(Request $request, $idBest)
    {
        $user = Auth::user();
        $best = Registry::get('route_best');
        $statusOrigine = $best["status"];
        $name = $request->input('url');
        if ($request->has('file') && !empty($request->input('file'))) {

            $name = ImageHelper::saveFromBase64($request->input('file'),'DEPOT_IMAGE_TEMP');
            $file = storage_path(env('DEPOT_IMAGE_TEMP')).'/'.$name;

            //@todo : on pose le fichier sur le ftp
            if (env('DEPOT_IMAGE_DRIVER')) {
                //faire le depot du fichier
                Config::set(
                    'filesystems.disks.depot_image',
                    Config::get('depot.image')
                );

                if (Storage::disk('depot_image')
                    ->exists(
                        env('DEPOT_IMAGE_REP') . "/" . $name
                    )
                ) {
                    Storage::disk('depot_image')
                        ->delete(
                            env('DEPOT_IMAGE_REP') . "/" . $name
                        );

                }

                Storage::disk('depot_image')
                    ->put(
                        env('DEPOT_IMAGE_REP') . "/" . $name,

                        \file_get_contents($file)
                    );


            }

        }

        //on enregistre le best


        switch ($request->input('status')) {

            case  'to_publish':
                $status = 'publie';
                $datepublication = Carbon::now();
                $datasuppression = null;


                break;
            case 'draft':
                $status = 'brouillon';
                $datepublication = null;
                $datasuppression = null;
                break;
            default:
                $status = null;
        }

        $title = $request->input('title') === null
            ? $best['titre']
            : $request->input('title');

        $description = $request->input('description') === null
            ? $best['description']
            : $request->input('description');


        $array = [
            'type' => 'type',
            'titre' => 'title',
            'description' => 'description',
            //'url_image' => $name,
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'address' =>'address',
            'place' => 'place',
            //'status' => $status,
            //'date_publication' => $datepublication,
        ];
        $enr = [];
        foreach ($array as $field => $input) {
            if ($request->input($input) !== null) {
                $enr[$field] = $request->input($input);
            }
        }

        if (!empty($name)) {
            $enr['url_image'] = $name;
        }

        if (!empty($status) && $best['status'] != $status) {
            $enr['status'] = $status;
            $enr['date_publication'] = $datepublication;
            $enr['date_suppression'] = $datasuppression;
        }

        if (!empty($enr)) {
            $best->update($enr);
        }

        if ($request->input('category') !== null) {
            $this->saveCategory(
                $request->input('category'),
                $best['id_best']
            );
        };

        //on extract les elemnts (tag,... ) des titre et description
        $extractTitle = \Twitter\Text\Extractor::create()
            ->extract($title);
        $extractDescription = \Twitter\Text\Extractor::create()
            ->extract($description);

        $tags = array_merge(
            $extractTitle['hashtags'],
            $extractDescription['hashtags']
        );

        $this->saveTags($tags, $best['id_best']);

        $cashtags = array_merge(
            $extractTitle['cashtags'],
            $extractDescription['cashtags']
        );

        $this->saveCashtags($cashtags, $best['id_best']);

        $urls = array_merge(
            $extractTitle['urls'],
            $extractDescription['urls']
        );

        $this->saveUrl($urls, $best['id_best']);

        $utilisateurs = array_merge(
            $extractTitle['mentions'],
            $extractDescription['mentions']
        );

        $this->saveUtilisateurs($utilisateurs, $best['id_best']);

        if ($status === null && $statusOrigine != $status) {
            switch ($status) {
                case 'brouillon':
                    CelebriteHelper::depublishBest($user['id_utilisateur']);
                    break;
                case 'publie':
                    CelebriteHelper::publishBest($user['id_utilisateur']);

                    break;
            }
        }

    }


    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @throws \Exception
     */
    public function delete(Request $request, $idBest)
    {
        $user = Auth::user();
        $best = Registry::get('route_best');

        $best->update(
            [
            'status' => 'supprime',
            'date_suppression' => Carbon::now(),

            ]
        );
        if($best['status'] == 'publie'){
            CelebriteHelper::depublishBest($user['id_utilisateur']);
        }
    }
    public function getBest(Request $request, $idBest)
    {
        /**
         * @var Best $best
         */

        $best = Registry::get('route_best');


        return $this->response()
            ->array(
                BestService::toAPi($best)
            );
    }

    public function getBests(Request $request)
    {

        $user = Registry::get('route_username');

        $offset = $request->input('offset',0);
        $limit = $request->input('limit',10);

        $rows = Best::where(
            'id_utilisateur_fk',
            $user['id_utilisateur']
        )
            ->where(
                'status',
                'publie'
            )
            ->orderBy('date_publication', 'desc')
            ->orderBy('nb_like','desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $response = [];
        foreach($rows as $best){
            $response[] = BestService::toAPi($best);
        }

        return $this->response()
            ->array(
                $response
            );
    }

    public function getDrafts(Request $request)
    {

        $user = Auth::user();

        $offset = $request->input('offset',0);
        $limit = $request->input('limit',10);

        $rows = Best::where(
            'id_utilisateur_fk',
            $user['id_utilisateur']
        )
            ->where(
                'status',
                'brouillon'
            )
            ->orderBy('date_modification', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $response = [];
        foreach($rows as $best){
            $response[] = BestService::toAPi($best);
        }

        return $this->response()
            ->array(
                $response
            );
    }

    /**
     * @param $category
     * @param $idbest
     */
    protected function saveCategory($category, $idbest)
    {
        //on enregistre les category
        if (!is_array($category)) {
            return;
        }
        BestCategorie::whereNotIn(
            'mot_cle',
            $category
        )
            ->where(
                'id_best_fk',
                $idbest
            )
            ->delete();

        foreach ($category as $motcle) {
            $tag = MotCle::where(
                'libelle',
                $motcle
            )->first();

            BestCategorie::UpdateOrCreate(
                [
                    'id_best_fk' => $idbest,
                    'mot_cle' => $motcle,
                ],
                [
                    'id_mot_cle_fk' => $tag['id_mot_cle'] ?? null,
                ]
            );
        }
    }

    /**
     * @param $tags
     * @param $idbest
     */
    protected function saveTags($tags, $idbest)
    {
        //on enregistre les category
        if (!is_array($tags)) {
            return;
        }
        BestTag::whereNotIn(
            'mot_cle',
            $tags
        )
            ->where(
                'id_best_fk',
                $idbest
            )
            ->delete();

        foreach ($tags as $motcle) {
            $tag = MotCle::where(
                'libelle',
                $motcle
            )->first();

            BestTag::UpdateOrCreate(
                [
                    'id_best_fk' => $idbest,
                    'mot_cle' => $motcle,
                ],
                [
                    'id_mot_cle_fk' => $tag['id_mot_cle'] ?? null,
                ]
            );
        }
    }

    /**
     * @param $tags
     * @param $idbest
     */
    protected function saveCashtags($cashtags, $idbest)
    {
        //on enregistre les category
        if (!is_array($cashtags)) {
            return;
        }
        BestCashtag::whereNotIn(
            'mot_cle',
            $cashtags
        )
            ->where(
                'id_best_fk',
                $idbest
            )
            ->delete();

        foreach ($cashtags as $motcle) {
            $tag = MotCle::where(
                'libelle',
                $motcle
            )->first();

            BestCashtag::UpdateOrCreate(
                [
                    'id_best_fk' => $idbest,
                    'mot_cle' => $motcle,
                ],
                [
                    'id_mot_cle_fk' => $tag['id_mot_cle'] ?? null,
                ]
            );
        }
    }

    /**
     * @param $utilisateurs
     * @param $idbest
     */
    protected function saveUtilisateurs($utilisateurs, $idbest)
    {
        //on enregistre les category
        if (!is_array($utilisateurs)) {
            return;
        }
        BestUtilisateur::whereNotIn(
            'pseudo',
            $utilisateurs
        )
            ->where(
                'id_best_fk',
                $idbest
            )
            ->delete();

        foreach ($utilisateurs as $pseudo) {
            $utilisateur = Utilisateur::where(
                'pseudo',
                $pseudo
            )->first();

            BestUtilisateur::UpdateOrCreate(
                [
                    'id_best_fk' => $idbest,
                    'pseudo' => $pseudo,
                ],
                [
                    'id_utilisateur_fk' => $utilisateur['id_utilisateur'] ?? null,
                ]
            );
        }
    }

    /**
     * @param $urls
     * @param $idbest
     */
    protected function saveUrl($urls, $idbest)
    {
        //on enregistre les category
        if (!is_array($urls)) {
            return;
        }
        BestUrl::whereNotIn(
            'url',
            $urls
        )
            ->where(
                'id_best_fk',
                $idbest
            )
            ->delete();

        foreach ($urls as $url) {
            BestUrl::UpdateOrCreate(
                [
                    'id_best_fk' => $idbest,
                    'url' => $url,
                ],
                [
                ]
            );
        }
    }

    /**
     * @param int $idBest
     *
     * @return int
     */
    public function like(int $idBest): int
    {
        $user = Auth::user();
        $best = Registry::get('route_best');

        if (count($this->selectLike($user['id_utilisateur'], $best['id_best'])->get()) == 0) {

                BestLikePar::UpdateOrCreate(
                    [
                        'id_best_fk' => $best['id_best'],
                        'id_utilisateur_fk' => $user['id_utilisateur'],
                    ],
                    [
                        'date_suppression' => null
                    ]
                );
            CelebriteHelper::likeBest($best['id_utilisateur_fk']);

        }

        return Best::majCOmpteur($idBest);

    }


    /**
     * @param int $idBest
     *
     * @return int
     */
    public function dislike(int $idBest): int
    {
        $user = Auth::user();
        $best = Registry::get('route_best');

        if (count($this->selectLike($user['id_utilisateur'], $best['id_best'])->get())) {

            $this
                ->selectLike($user['id_utilisateur'], $best['id_best'])
                ->update(
                    [
                        'date_suppression' => Carbon::now(),
                    ]
                );
            CelebriteHelper::dislikeBest($best['id_utilisateur_fk']);
        }

        return Best::majCOmpteur($idBest);

    }

    /**
     * @param int $idutilisateur
     * @param int $idbest
     *
     * @return mixed
     */
    protected function selectLike(int $idutilisateur, int $idbest)
    {
        return BestLikePar::where(
            'id_utilisateur_fk',
            $idutilisateur
        )->where(
            'id_best_fk',
            $idbest
        )->whereNull(
            'date_suppression'
        );
    }

}

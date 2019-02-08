<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Services\ThemeService;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Validator;


/**
 * Class TestController
 *
 * @package App\Http\Controllers\Api\V1
 */
class TestController extends ApiController
{

    /**
     *
     */
    public function index()
    {

        return storage_path(env('DEPOT_IMAGE_TEMP')) . '/' . 'aaa';

        \file_exists(storage_path(env('DEPOT_URL_IMAGE_PUBLIC')) . '/' . $this->attributes['url_image'])
            ? env('DEPOT_URL_IMAGE_PUBLIC') . $this->attributes['url_image']
            : $this->attributes['url_image'];

        return ThemeService::fluxTheme(4, 10, 0);
    }

    public function test(Request $request)
    {

        print_r($request->file('file'));

        $validator = Validator::make(
            ['file' => 'data:image/jpg;base64,rererere'], //'aaaa/sss;base65,ddd'],
            [
                'file' => ['nullable', 'image_base64:png,jpeg'],
            ]
        );
        if ($validator->fails()) {
            return $validator->errors();
        }


        return [];

    }

    protected function twitter()
    {
        $text = "test pour @payalba #test #zzz #test voir";


        $text = "\"L’#EconomieCirculaire vise à faire attention à toutes les étapes de la vie d’un produit. Comment
        # a été produit ce bien, comment est-il utilisé, comment sera-t-il recyclé ? Cherchons un nouveau modèle économique.\" Via @RevueLimite :";

        $text = "Tweet mentioning @mikenz and referring to his list @mikeNZ/sports and website http://mikenz.geek.nz #awesome";

        return \Twitter\Text\Extractor::create()
            ->extract($text);

    }

    protected function testTrim()
    {

        $input = [
            'a' => ' b ',
            'c' => [
                'nom' => '  ddd ',
                'prenom' => [' ggg', ' ff '],
                'prenom2' => [
                    [
                        ' p1 ',
                        ' ff2 ',
                    ],
                ],

                'date' => ['naissance' => '????'],
            ],
        ];

        $field = [
            'a' => true,
            'c.nom' => true,
            'c.*.prenom' => true,
            //'c.*.prenom.*.suite' => true,
            'date.naissance' => true,
        ];

        return $this->trim($input, $field);
    }


    protected function trim(array $input, array $field): array
    {
        if (!empty($field)) {

            foreach ($field as $name => $nullable) {
                $nameToProceed = explode('.', $name);

                $this->trimPorcessed($input, $nameToProceed, $nullable);
            }
        }

        return $input;
    }

    protected function trimPorcessed(&$input, $namesToProceed, $nullable)
    {

        echo "\n--------\n";

        $nameToPorceed = current($namesToProceed);
        $id = key($namesToProceed);

        if (count($namesToProceed) > 1) {
            unset($namesToProceed[$id]);
            if ($nameToPorceed == '*') {
                echo 'ici';
                $nameToPorceed = current($namesToProceed);
                $id = key($namesToProceed);

                echo $nameToPorceed . ' ' . $id . "'  '";
                if (is_array($input) && \key_exists($nameToPorceed, $input)) {
                    foreach ($input[$nameToPorceed] as $key => $value) {
                        echo $key . "=>" . $value;
                        print_r($input[$nameToPorceed][$key]);
                        print_r($namesToProceed);
                        echo '<<<';
                        //todo tester si tableau ou pas pour
                        //'name.*.test.*.aaaa'
                        $this->trimPorcessed($input[$nameToPorceed], [$key], $nullable);

                    }
                }
                unset($namesToProceed[$id]);

            } else {
                if (is_array($input) && \key_exists($nameToPorceed, $input)) {
                    $this->trimPorcessed($input[$nameToPorceed], $namesToProceed, $nullable);
                }
            }
        } else {
            echo $nameToPorceed . ' ';
            if (\key_exists($nameToPorceed, $input)) {
                $input[$nameToPorceed] = trim($input[$nameToPorceed]);
                if ($nullable && empty($input[$nameToPorceed])) {
                    $input[$nameToPorceed] = null;
                }
            }
        }
    }
}

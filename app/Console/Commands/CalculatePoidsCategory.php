<?php

namespace App\Console\Commands;


use App\Services\Poids;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CalculatePoidsCategory extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     *
     * tiers = code du tiers
     * nbmaxscheduler = nombre maximum de scheduler pouvant etre alncé en meme temps pour un même tiers
     * durée = durée de traitement de tache avant de quitter le traitement
     * nbenreg = nombre d'enregistement traité avant dev faire une pause
     * pause = durée de la pause
     */
    protected $signature = 'calculate:poids_categorie';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcule les poids des categories des utilisateurs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
// àtodo : prevoir de passer des plage d'idutilisateur 0-500, 501-1001, ...
            Poids::process();

        } catch (\Exception $exception) {
            Log::error(
                print_r(
                    [
                        'method' => __METHOD__,
                        'Exception' => [
                            'code' => $exception->getCode(),
                            'message' => $exception->getMessage(),
                            'trace' => $exception->getTraceAsString(),
                        ],
                    ], true)
            );

            return -1;
        }

        return 0;
    }

}

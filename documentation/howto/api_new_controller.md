[Retour à l'index](../index.md)  --

## API : Ajouter un nouveau controller

Ce document explique comment créer des controllers d'api (dingo)

### Création du controller

Dans le repertoire app/Http/Controllers/Api, créer une classe comme ci-dessous : 

````
namespace App\Http\Controllers\Api;
...
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;

use App\Http\Controllers\Api\ApiController;

class MonControllerApi extends ApiController
{

    use ApiHelpers;
    public function getInfos(ActionLogRepository $actionLogRepository): Response
    {
        $actionsLog = $actionLogRepository->all(['id', 'user_id', 'request', 'action']);
        return $this->response()->collection($actionsLog, new ActionLogTransformer());
    }
}
````


Les controllers doivent respecter la structure suivante

````
Http
    Controlleres
        Api
            V[1-9]
                MonController.php
````

Dans le controller, ajouter le trait ApiHelpers, formattant les réponses en mode api.

````
use ApiHelpers;
````

### Type de réponses

L'action doit retourner une réponse via la méthode $this->response. Cependant, plusieurs types de réponses existent : 

- Retourner une collection de modèles : $this->response()->collection($maCollectionDeModel,new MonModelTransformer());
- Retourner un modèle : $this->response()->item($monModel,new MonModelTransformer());
- Retourner un tableau : $this->response()->array($unArray);
- Retourner une erreur : $this->response()->error('bla',502); ou $this->response()->errorBadRequest('Un message d\'erreur');
- Retourner un statut : $this->response()->created() ou $this->response()->accepted() ou $this->response()->noContent();
    
#### Ajouter un format de réponse

Par défaut, seul le JSON est présent, il est possible d'en ajouter dans l'option api.formats[]

## Fichier de routing

Dans le fichier routes/web.php, le router doit être une instance de Dingo\Api\Routing\Router et reprendre la structure 
ci-dessous :

````
use Dingo\Api\Routing\Router;


$api = app(Router::class);
        
        // url:http://monapp/api/infos
        // url de l'api, controller@action
        $api->get('infos',[],'App\Http\Controllers\Api\MonControllerApi@getInfos');

        
        // url:http://monapp/api/un_prefixe_de_route
        // groupes de routes utilisant un prefix
        $api->group(['prefix' => 'un_prefixe_de_route',[], function ($api) {
            $api->get('autres-infos', 'App\Http\Controllers\Api\MonControllerApi@index');
            $api->post('encore-un-exemple', 'App\Http\Controllers\Api\MonControllerApi@test');
        }); 
````

Pour ajouter des middlewares, sur les routes, cela fonctionne comme avec le système de Lumen

````
  $api->get('infos',['middleware'=>'un_middleware','uses' =>  'App\Http\Controllers\Api\MonControllerApi@getInfos']);  
````

### Documentation de l'API
La documentation de l'api est faite à l'aide de swagger.
Les fichier yaml décrivant les apis sont dans le répertoire : [/api/documentation/swagger](../swagger)
Les fichiers yaml sont visualisables via l'[]éditeur](https://editor.swagger.io/) de swagger



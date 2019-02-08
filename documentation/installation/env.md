[Retour à l'index](../index.md)

## Configurer le .env ##


Il faut dupliquer le fichier .env.example en .env et mettre à jour les variables
* pour la base de données
``` 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=woozbest
DB_USERNAME=root
DB_PASSWORD=
``` 

* le cache 
``` 
CACHE_DRIVER=file
``` 


* les apis
``` 
API_ENABLED=true
API_STANDARDS_TREE=vnd
API_SUBTYPE=wooz_best
#API_PREFIX=api
API_DOMAIN=api.wooz.best.local
API_VERSION=v1
API_NAME="Wooz Best Api"
API_CONDITIONAL_REQUEST=true
API_STRICT=false
API_DEFAULT_FORMAT=json
API_DEBUG=true
``` 

* les logs
``` 
LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=
``` 

* l'application 
(Pour la clé de sécurité mmettre une chaines de 32 caractères)
``` 
APP_ENV=local
APP_DEBUG=true
APP_KEY=g13aP54fAcn4UnICGFQvgMUjlYmWDrGH
APP_TIMEZONE=UTC
``` 

* la durée des session (en minute)
``` 
AUTH_SESSION_MAX_LIFETIME = 525600
``` 

Pour plus d'informations voir la doc de 
* [lumen](https://lumen.laravel.com/)
* [dingo](https://github.com/dingo/api/wiki)




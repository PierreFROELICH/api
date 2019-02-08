[Retour à l'index](../index.md)

##installation du serveur ##

### Créer un vhost ##

Il faut créer un vhost qui pointe vers le répertoire public de l'application comme :

```
<VirtualHost *:80>          
    ServerName api.wooz.best.local
    DocumentRoot "C:/MonSIte/woozbest/api/public"
    SetEnv APP_ENV "development"	
    <Directory "C:/MonSIte/woozbest/api/public">
        AllowOverride AuthConfig FileInfo
        AllowOverride All
        Order allow,deny
        Allow from all
       </Directory>
</VirtualHost>
```

### Mettre à jour son dns si nécessaire ###


Exemple : 
Ajouter la ligne suivante dans son fichier hosts.

```
127.0.0.1 api.wooz.best.local
```

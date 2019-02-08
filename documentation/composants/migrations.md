[Retour à l'index](../index.md)

## Création des migrations à partir des BDD

### Composant

Github :
https://github.com/Xethron/migrations-generator

### Explications 
#### Créer les fichiers de migration pour toutes les tables :
```
php artisan migrate:generate
```

#### Créer les fichiers de migrations pour certaines tables seulement
```
php artisan migrate:generate table1,table2,table3,table4,table5
```

#### Créer les fichiers de migration en ignorant certaines tables

```
php artisan migrate:generate --ignore="table3,table4,table5"
```

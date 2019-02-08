[Retour à l'index](../index.md)

## Gestion des clés primaires composées ##

### Composant

Github : 
https://packagist.org/packages/mopo922/laravel-treats

### Comment définir une clé primaire composée ?

Exemple :
```php
class MyModel extends Eloquent {
    use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;

    /**
     * The primary key of the table.
     *
     * @var array
     */
    protected $primaryKey = ['key1', 'key2'];

    ...
```

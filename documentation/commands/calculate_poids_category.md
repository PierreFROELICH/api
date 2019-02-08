
[Retour à l'index](../index.md)  
  
## Calcul ou recalcul les catégories d'un utilisateur   
  
### Commande  
  
```  
php artisan calculate:poids_categorie  
```  
 Cette commande va analyser et calculer les catégories pendant 1 minute.
  La commande peut être lancée manuellement ou installée dans une crontab.
 La fréquence d'exécution est 1 minute 
 
 #### Exemple de crontab: 
```  
*/1 * * * * php artisan calculate:poids_categorie >/dev/null 2>&1
``` 

### Explications  
  
Cette commande va :   
  
- Calculer ou recalculer les catégories (tags) des utilisateurs et évaluer le poids de chaque tag.
Les poids des catégories sont exprimés en %. La somme des poids d'un utilisateur est donc de 100%

Pour le calcul, la commande analyse la fréquence pondérée des tags de l'utilisateur à traiter dans : 
- les tops , les bests et les bests des tops des utilisateurs suivi ,
- ses propres tops ,  bests et  bests  de ses tops  ,
 - des tops et bests qu'il a liké, 
- et de ses catégories saisies à l'inscription.

Les poids pour le calcul des fréquences sont paramétrés dans le fichier
```  
config/poids.php
```
Le calcul est relancé si un des éléments entrés dans le calcul a été ajouté ou modifié depuis le dernier calcul.

La commande peut ausi être lancé en http (via un browser) :
```  
http://api.wooz.best/process/poids
```  

### Améliorations :

Permettre à la commande d'accepter des tranches d'id utilisateur à traiter afin de permettre une parallélisation des calcul

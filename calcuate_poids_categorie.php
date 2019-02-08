<?php
// On simule l'appel à `artisan schedule:run`
$_SERVER['argv'] = [
    'artisan',
    'calculate:poids_categorie',
];

// On lance artisan
require __DIR__.'/artisan';

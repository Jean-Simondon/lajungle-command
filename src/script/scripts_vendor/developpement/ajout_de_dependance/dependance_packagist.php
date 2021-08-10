<?php

namespace Scripts;

use Validator\Validator;

// Validator::getInstance()->require([
    
// ]);

/**
 * Créer un fichier de config et faire itérer dessus
 * pour toutes les constantes à créer
 */

$this->display("Ajout de dépendance");

    $this->askInputKeyInArray(
        "Quel dépendance ajouter ?",
        [
            '1' => 'EXIT',
            '2' => 'mobiledetect/mobiledetectlib',
            '3' => 'monolog/monolog',
            '4' => 'illuminate/database',
            '5' => 'filp/whoops',
            '6' => 'vlucas/phpdotenv',
            '7' => 'wordplate/acf',
        ],
        "REQUIRE"
    );

if( $this->get("REQUIRE") !== "EXIT" ) {

    $this->shell_exec("cd " . LJD_PROJECT_ROOT . "/ && composer require '" . $this->get("REQUIRE") . "' --no-update")

    ->display('Vous devez encore lancer la commande "composer update" pour que cela soit effectif');

}
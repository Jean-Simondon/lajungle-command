<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([
    
]);

/**
 * Créer un fichier de config et faire itérer dessus
 * pour toutes les constantes à créer
 */
$project_root = str_replace( " " , "\ " , PROJECT_ROOT);

$this->display("Ajout de dépendance")

    ->askInputNumber(
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

    $this->shell_exec("cd " . PROJECT_ROOT . "/ && composer require '" . $this->get("REQUIRE") . "' --no-update", true)

    ->display('Vous devez encore lancer la commande "composer update" pour que cela soit effectif');

}
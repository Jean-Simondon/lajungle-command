<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

/**
 * Créer un fichier de config et faire itérer dessus
 * pour toutes les constantes à créer
 */

$this->display("Ajout de dépendance")

    ->askInputKeyInArray(
        "Quel dépendance ajouter ?",
        [
            '1' => 'EXIT',
            '2' => 'show -lo',
            '3' => 'outdated',
            '4' => '',
            '5' => '',
            '6' => '',
            '7' => '',
            '8' => '',
            '9' => '',
            '10' => '',
            '11' => '',
            '12' => '',
            '13' => '',
            '14' => '',
            '15' => '',
            '16' => '',
            '17' => '',
            '18' => '',
            '19' => '',
            '20' => '',
        ],
        "CMD"
    );

if( $this->get("CMD") !== "EXIT" ) {

    $this->shell_exec("cd " . LJD_PROJECT_ROOT . "/ && composer " . $this->get("CMD"));

}

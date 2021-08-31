<?php

use Validator\Validator;

// Validator::getInstance()->require([]);

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
            '4' => 'diagnose',
            '5' => '--list l',
            '6' => 'validate',
            '7' => 'diagnose',
            // '8' => 'exec --list',
            // '9' => 'exec php unit',
        ],
        "CMD"
    );

if( $this->get("CMD") !== "EXIT" ) {
    $this->shell_exec("cd " . LJD_PROJECT_ROOT . "/ && composer " . $this->get("CMD"));
}

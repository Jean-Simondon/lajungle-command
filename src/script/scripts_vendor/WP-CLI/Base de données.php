<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

/**
 * Créer un fichier de config et faire itérer dessus
 * pour toutes les constantes à créer
 */

$this->display("Commande sur base de données")

    ->askInputKeyInArray(
        "Quel dépendance ajouter ?",
        [
            '1' => 'EXIT',
            '2' => 'create',
            '3' => 'check',
            '4' => 'cli',
            '5' => "columns 'table'",
            '6' => 'create',
            '7' => 'import',
            '8' => 'export',
            '9' => 'optimize',
            '10' => 'prefix',
            '11' => 'repair',
            '12' => 'search',
            '13' => 'tables',
        ],
        "CMD"
    );

if( $this->get("CMD") == "EXIT" ) {
    $this->dismiss();
}

if( $this->get("CMD") == "columns 'table'" ) {

    $this->display("Quelle nom de tables ? [ wp_posts, wp_users, wp_options... ]")
        ->askInputText("TABLE")
        ->shell_exec("wp db columns " + $this->get("TABLE"));

} else {
    $this->shell_exec("wp db " + $this->get("CMD"));
}

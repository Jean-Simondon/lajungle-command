<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

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
            '2' => 'acf-pro',
            '3' => 'wp-rocket',
            '4' => 'gravityforms',
            '5' => 'polylang_pro',
            '6' => 'wp_media_folder',
            '7' => 'ljd-mu-plugins',
            '8' => 'webtoffee-gdpr-cookie-consent',
            '9' => 'iquitos',
            '10' => 'ignition',
            '11' => 'iquitheme'
        ],
        "REQUIRE"
    );

if( $this->get("REQUIRE") !== "EXIT" ) {

    $this->shell_exec("cd " . PROJECT_ROOT . "/ && composer require 'lajungle/" . $this->get("REQUIRE") . "' --no-update", true)

    ->display('Vous devez encore lancer la commande "composer update" pour que cela soit effectif');

}
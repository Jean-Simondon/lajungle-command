<?php

namespace Scripts;

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
            '2' => 'acf-gravityforms-add-on',
            '3' => 'wordpress-seo',
            '4' => 'crop-thumbnails',
            '5' => 'regenerate-thumbnails',
            '6' => 'post-type-archive-links',
            '7' => 'tablepress',
            '8' => 'advanced-access-manager'
        ],
        "REQUIRE"
    );

if( $this->get("REQUIRE") !== "EXIT" ) {

    $this->shell_exec("cd " . LJD_PROJECT_ROOT . "/ && composer require 'wpackagist-plugin/" . $this->get("REQUIRE") . "' --no-update")

    ->display('Vous devez encore lancer la commande "composer update" pour que cela soit effectif');

}

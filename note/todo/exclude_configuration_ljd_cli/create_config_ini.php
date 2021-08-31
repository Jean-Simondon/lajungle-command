<?php

namespace Scripts;

use Exception;
use Validator\Validator;

// Validator::getInstance()->require([
//     "project_is_know"
// ]);

/**
 * Créer un fichier de config et faire itérer dessus
 * pour toutes les constantes à créer
 */
// if( !defined('LJD_PROJECT_ROOT')) {
//     throw new Exception("Absence de la constante LJD_PROJECT_ROOT\n");
// }

$this->display("Bienvenue dans l'outils de création du fichier de configuration config.ini")
    ->display("Ce fichier est important afin de guider l'outils ljd-cli dans l'arborescence de votre projet")

    ->askInputKeyInArray(
        "Type de project ?",
        [
            '1' => 'iquitheme',
            '2' => 'loreto'
        ],
        "PROJECT_TYPE"
    )

    ->display("Nom du theme (sans - ni _ ni majuscule")->askInputText("THEME_NAME")

    ->askInputKeyInArray(
        "Version de PHP à utiliser ?",
        [
            '1' => '5.4',
            '2' => '5.6',
            '3' => '7.0',
            '4' => '7.1',
            '5' => '7.2',
            '6' => '7.3',
            '7' => '7.4'
        ],
        "PHP_V"
    )

    ->display("Merci, c'est terminé");

$content = "";

if ( !empty( $this->get("PROJECT_TYPE") ) ) {
    $content .= "PROJECT_TYPE=" . $this->get("PROJECT_TYPE");
    $content = trim($content);
}

if (!empty($this->get("THEME_NAME"))) {
    $content .= "\nTHEME_NAME=" . $this->get("THEME_NAME");
    $content = trim($content);
}

if (!empty($this->get("PHP_V"))) {
    $content .= "\nPHP_V=" . $this->get("PHP_V");
    $content = trim($content);
}

if (!empty($content)) {
    $this->display("Création du fichier config-for-ljd-cli.ini")
        ->shell_exec("cd " . LJD_PROJECT_ROOT . " && echo \"" . $content . "\" > config-for-ljd-cli.ini")
        ->display("C'est un succès, vous pouvez retrouver le fichier config-for-ljd-cli.ini à la racine du projet")
        ->display("IMPORTANT : vous devez quitter et relancer ljd.phar pour prendre ce fichier en compte");
}


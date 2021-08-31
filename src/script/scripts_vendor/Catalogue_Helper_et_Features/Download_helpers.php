<?php

use Validator\Validator;
Validator::getInstance()->require([]);

/**
 * Créer un fichier de config et faire itérer dessus
 * pour toutes les constantes à créer
 */

$this->display("Ajout de Helpers")

    ->askInputKeyInArray(
        "Quel Helper ajouter ?",
        [
            '1' => 'EXIT',
            '2' => 'BreadCrumbHelper.php',
            '3' => 'CookieHelper.php',
            '4' => 'CptHelper.php',
            '5' => 'DateHelper.php',
            '6' => 'EmailHelper.php',
            '7' => 'EnvHelper.php',
            '8' => 'LangHelper.php',
            '9' => 'MailHelper.php',
            '10' => 'MapsHelper.php',
            '11' => 'MediaHelper.php',
            '12' => 'MobileHelper.php',
            '13' => 'NewsletterHelper.php',
            '14' => 'PageHelper.php',
            '15' => 'PaginateHelper.php',
            '16' => 'PostHelper.php',
            '17' => 'RegexHelper.php',
            '18' => 'SessionHelper.php',
            '19' => 'TaxoHelper.php',
            '20' => 'TextHelper.php',
            '21' => 'TranslateHelper.php',
            '22' => 'UserHelper.php',
            '23' => 'UtilsHelper.php',
            '24' => 'Varhelper.php',
            '25' => 'VideoHelper.php',
        ],
        "REQUIRE"
    );


if( $this->get("REQUIRE") === 'EXIT' ) {
    $this->endScript();
}

$HELPER_REPO = LJD_CMD_ROOT . "/code_snippet/helpers/";

/**
* Ajout du fichier Helpers
*/
if( file_exists( $HELPER_REPO . $this->get("REQUIRE") ) ) {

    if( file_exists( STYLESHEETPATH . '/resources/helpers/' . $this->get("REQUIRE") )) {

        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le Helper en question existe déjà");

    } else {

        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/ressources/helpers/")) {
            $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/helpers", false);
        }

        $this->display("Création du Helpers")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $HELPER_REPO . $this->get("REQUIRE") . " " . STYLESHEETPATH . "/resources/helpers/" . $this->get("REQUIRE"), false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/helpers/ && find . -name "'.$this->get("REQUIRE").'" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false);

    }

}



<?php

use Validator\Validator;
Validator::getInstance()->require([]);

/**
 * Créer un fichier de config et faire itérer dessus
 * pour toutes les constantes à créer
 */

$this->display("Ajout de Features")

    ->askInputKeyInArray(
        "Quel Features ajouter ?",
        [
            '1' => 'EXIT',
            '2' => 'FeatureAccount.php',
            '3' => 'FeatureACFCustomFields.php',
            '4' => 'FeatureAdmin.php',
            '5' => 'FeatureGravity.php',
            '6' => 'FeatureHeader.php',
            '7' => 'FeatureLocalization.php',
            '8' => 'FeatureMailTrap.php',
            '9' => 'FeatureNewsletter.php',
            '10' => 'FeaturePost.php',
            '11' => 'FeatureSeo.php',
            '12' => 'FeatureThemeConfig.php',
            '13' => 'FeatureTranslate.php',
            '14' => 'FeatureViewComposer.php'
        ],
        "REQUIRE"
    );


if( $this->get("REQUIRE") === 'EXIT' ) {
    $this->endScript();
}

$FEATURE_REPO = LJD_CMD_ROOT . "/code_snippet/features/";

/**
* Ajout du fichier Feature
*/
if( file_exists( $FEATURE_REPO . $this->get("REQUIRE") ) ) {

    if( file_exists( STYLESHEETPATH . '/resources/features/' . $this->get("REQUIRE") )) {

        // Pour ne pas écraser le fichier s'il existe
        $this->display("La Feature en question existe déjà");

    } else {

        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/ressources/features/")) {
            $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/features", false);
        }

        $this->display("Création de la features")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $FEATURE_REPO . $this->get("REQUIRE") . " " . STYLESHEETPATH . "/resources/features/" . $this->get("REQUIRE"), false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/ && find . -name "'.$this->get("REQUIRE").'" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false);

    }

}


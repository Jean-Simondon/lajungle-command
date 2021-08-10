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
            '2' => '@babel/core',
            '3' => '@babel/preset-env',
            '4' => 'browser-sync',
            '5' => 'del',
            '6' => 'gulp',
            '7' => 'gulp-autoprefixer',
            '8' => 'gulp-babel',
            '9' => 'gulp-cache',
            '10' => 'gulp-concat',
            '11' => 'gulp-jshint',
            '12' => 'gulp-load-plugins',
            '13' => 'gulp-notify',
            '14' => 'gulp-rename',
            '15' => 'gulp-sass',
            '16' => 'gulp-sourcemaps',
            '17' => 'gulp-uglify',
            '18' => 'jshint',
            '19' => 'node-sass',
        ],
        "REQUIRE"
    );

if( $this->get("REQUIRE") !== "EXIT" ) {

    $this->shell_exec("cd " . STYLESHEETPATH . "/ && npm install " . $this->get("REQUIRE"));

}

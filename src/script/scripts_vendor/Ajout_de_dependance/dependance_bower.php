<?php

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
            '2' => 'jssocials',
            '3' => 'jquery.cookie',
            '4' => 'slick-carousel',
            '5' => 'slick-lightbox',
            '6' => 'enquire',
            '7' => 'what-input',
            '8' => 'modaal',
            '9' => 'matchHeight',
            '10' => 'jquery.easing',
            '11' => 'gsap',
            '12' => 'swiper',
            '13' => 'stickybits',
            '14' => 'magnific-popup',
            '15' => 'object-fit-images',
            '16' => 'parallax.js',
            '17' => 'tilt',
            '18' => 'fullpage.js',
            '19' => 'objectFitPolyfill',
            '20' => 'scrollmagic',
        ],
        "REQUIRE"
    );

if( $this->get("REQUIRE") !== "EXIT" ) {

    $this->shell_exec("cd " . STYLESHEETPATH . "/ && bower install --save " . $this->get("REQUIRE"));

}

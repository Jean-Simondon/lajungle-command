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

    if( $this->shell_exec("cd " . STYLESHEETPATH . "/ && grep \"gulp.task('plugins'\" gulpfile.js", false)) {
        // print_r('fonctionne');        // do stuff
        print_r( $this->shell_exec("cd " . STYLESHEETPATH . "/ && grep \"gulp.task('plugins'\" gulpfile.js", false) );        // do stuff
    }
    // $this->shell_exec("cd " . STYLESHEETPATH . "/ && npm install " . $this->get("REQUIRE"));

}




// resources/assets/js/vendor/jquery.cookie/jquery.cookie.js',
// 'resources/assets/js/vendor/swiper/package/js/swiper.min.js',
// 'resources/assets/js/vendor/stickybits/dist/stickybits.min.js',



// 'resources/assets/js/vendor/jquery.cookie/jquery.cookie.js',
// 'resources/assets/js/vendor/slick-carousel/slick/slick.js',
// 'resources/assets/js/vendor/magnific-popup/dist/jquery.magnific-popup.min.js'



// 'resources/assets/js/vendor/what-input/dist/what-input.min.js',
// 			'resources/assets/js/vendor/enquire/dist/enquire.min.js',
// 			'resources/assets/js/vendor/slick-carousel/slick/slick.min.js',
// 			'resources/assets/js/vendor/modaal/dist/js/modaal.min.js',
// 			'resources/assets/js/vendor/matchHeight/dist/jquery.matchHeight-min.js',
// 			'resources/assets/js/vendor/jquery.easing/js/jquery.easing.min.js',
// 			'resources/assets/js/vendor/jssocials/dist/jssocials.min.js',
// 			'resources/assets/js/vendor/gsap/dist/gsap.min.js',
// 			'resources/assets/js/vendor/gsap/dist/ScrollTrigger.min.js',


//             'resources/assets/js/vendor/what-input/dist/what-input.min.js',
//         'resources/assets/js/vendor/enquire/dist/enquire.min.js',
//         'resources/assets/js/vendor/slick-carousel/slick/slick.min.js',
//         'resources/assets/js/vendor/modaal/dist/js/modaal.min.js',
//         'resources/assets/js/vendor/matchHeight/dist/jquery.matchHeight-min.js',
// 		'resources/assets/js/vendor/jssocials/dist/jssocials.min.js',
// 		'resources/assets/js/vendor/gsap/dist/gsap.min.js',
// 		'resources/assets/js/vendor/gsap/dist/ScrollTrigger.min.js',


//         'resources/assets/js/vendor/what-input/dist/what-input.min.js',
//       'resources/assets/js/vendor/enquire/dist/enquire.min.js',
//       'resources/assets/js/vendor/slick-carousel/slick/slick.min.js',
//       'resources/assets/js/vendor/float-labels.js/dist/float-labels.js',
//       'resources/assets/js/vendor/modaal/dist/js/modaal.min.js',
//       'resources/assets/js/vendor/matchHeight/dist/jquery.matchHeight-min.js',
//       'resources/assets/js/vendor/jquery.cookie/dist/jquery.cookie.js',
//       'resources/assets/js/vendor/jquery.easing/js/jquery.easing.min.js',
//       'resources/assets/js/vendor/object-fit-images/dist/ofi.browser.js',
//       'resources/assets/js/vendor/jssocials/dist/jssocials.min.js',
//       'resources/assets/js/vendor/gsap/dist/gsap.min.js',
//       'resources/assets/js/vendor/gsap/dist/ScrollTrigger.min.js',


//       'resources/assets/js/vendor/what-input/dist/what-input.min.js',
//         'resources/assets/js/vendor/enquire/dist/enquire.min.js',
//         'resources/assets/js/vendor/slick-carousel/slick/slick.min.js',
//         'resources/assets/js/vendor/modaal/dist/js/modaal.min.js',
//         'resources/assets/js/vendor/matchHeight/dist/jquery.matchHeight-min.js',
//         'resources/assets/js/vendor/object-fit-images/dist/ofi.browser.js',


//         'resources/assets/js/vendor/jquery.cookie/jquery.cookie.js',
// 		'resources/assets/js/vendor/matchHeight/dist/jquery.matchHeight-min.js',
// 		'resources/assets/js/vendor/object-fit-images/dist/ofi.browser.js',
// 		'resources/assets/js/vendor/enquire/dist/enquire.min.js',
// 		'resources/assets/js/vendor/slick-carousel/slick/slick.min.js',
// 		'resources/assets/js/vendor/slick-lightbox/dist/slick-lightbox.min.js',
// 		'resources/assets/js/vendor/jssocials/dist/jssocials.min.js',
// 		'resources/assets/js/vendor/parallax.js/parallax.min.js',
// 		'resources/assets/js/vendor/tilt/dest/tilt.jquery.js',

//         'resources/assets/js/vendor/gsap/dist/gsap.min.js',
//         'resources/assets/js/vendor/jquery.cookie/jquery.cookie.js',
//         'resources/assets/js/libs/fullpage.scrollHorizontally.min.js',
//         'resources/assets/js/libs/fullpage.responsiveSlides.min.js',
//         'resources/assets/js/vendor/fullpage.js/dist/fullpage.extensions.min.js',
//         'resources/assets/js/vendor/stickybits/dist/stickybits.min.js',
//         'resources/assets/js/vendor/swiper/package/js/swiper.min.js',
//         'resources/assets/js/vendor/scrollmagic/scrollmagic/minified/ScrollMagic.min.js',
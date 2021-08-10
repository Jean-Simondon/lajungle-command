<?php

return [

    // "project_is_know" => [
    //     "error_message" => "Pour continuer, vous devez placer wp-cli.phar à la racine d'un répertoire qui sera votre projet",
    //     "callback" => function() {
    //         return defined("WP_CLI_PHAR_PATH") && is_dir( WP_CLI_PHAR_PATH );
    //     },
    // ],

    // "project_type_is_know" => [
    //     "error_message" => "Le type de projet n'est pas connu [ écrire iquitheme ou loreto dans config-for-ljd-cli.ini ]",
    //     "callback" => function() {
    //         return defined( 'PROJECT_TYPE' );
    //     },
    // ],

    // "theme_dir_exists" => [
    //     "error_message" => "le répertoire de thème n'existe pas ou n'est pas trouvé",
    //     "callback" => function() {
    //         return ( defined( 'THEMES_PATH' ) && file_exists( THEMES_PATH . "/" ) );
    //     },
    // ],

    // "mu_plugins_dir_exists" => [
    //     "error_message" => "le répertoire de mu plugins n'existe pas ou n'est pas trouvé",
    //     "callback" => function() {
    //         return ( defined( 'STYLESHEETPATH' ) && file_exists( STYLESHEETPATH  . "/" ) );
    //     },
    // ],

    // "plugins_dir_exists" => [
    //     "error_message" => "le répertoire de plugins n'existe pas ou n'est pas trouvé",
    //     "callback" => function() {
    //         return ( defined( 'STYLESHEETPATH' ) && file_exists( STYLESHEETPATH  . "/" ) );
    //     },
    // ],

    // "cms_dir_exists" => [
    //     "error_message" => "le répertoire de cms n'existe pas ou n'est pas trouvé",
    //     "callback" => function() {
    //         return ( defined( 'CMS_PATH' ) && file_exists( CMS_PATH  . "/" ) );
    //     },
    // ],

    // "theme_exists" => [
    //     "error_message" => "le thème n'existe pas ou n'est pas trouvé",
    //     "callback" => function() {
    //         return ( defined( "STYLESHEETPATH" ) && file_exists( STYLESHEETPATH . '/' ) );
    //     },
    // ],

    // "package_json_theme_exists" => [
    //     "error_message" => "le fichier package.json dans le theme n'existe pas ou n'est pas trouvé",
    //     "callback" => function() {
    //         return file_exists( STYLESHEETPATH . '/package.json' );
    //     },
    // ],

    // "bower_json_theme_exists" => [
    //     "error_message" => "le fichier bower.jso dans le theme n'existe pas ou n'est pas trouvé",
    //     "callback" => function() {
    //         return file_exists( STYLESHEETPATH . '/bower.json' );
    //     },
    // ],

    // "gulpfile_theme_exists" => [
    //     "error_message" => "le fichier gulpfile dans le theme n'existe pas ou n'est pas trouvé",
    //     "callback" => function() {
    //         return file_exists( STYLESHEETPATH . '/gulpfile.js' );
    //     },
    // ],

    // "composer_json_exist" => [
    //     "error_message" => "le fichier composers.json dans le theme n'existe pas ou n'est pas trouvé",
    //     "callback" => function() {
    //         return file_exists( LJD_PROJECT_ROOT . '/composer.json' );
    //     },
    // ],

    // "project_is_blank" => [
    //     "error_message" => "Vous ne pouvez pas exécuter ce script alors que ljd-cli se trouve déjà à la racine d'un autre projet",
    //     "callback" => function() {
    //         return ! ( defined("WP_CLI_PHAR_PATH") && is_dir( WP_CLI_PHAR_PATH ) );
    //     },
    // ],

    // "wp-cli.phar" => [
    //     "error_message" => "wp-cli.phar ou wp-cli.yml absent ou pas trouvé à la racine du projet",
    //     "callback" => function() {
    //         return file_exists( LJD_PROJECT_ROOT . '/wp-cli.phar' ) && file_exists( LJD_PROJECT_ROOT . '/wp-cli.yml' );
    //     },
    // ],

    // "placeholder" => [
    //     "error_message" => "placeholder",
    //     "callback" => function() {
    //         return file_exists( PATH_IN_CONSTANT . '/file.txt' );
    //     },
    // ],

    // "placeholder" => [
    //     "error_message" => "placeholder",
    //     "callback" => function() {
    //         return file_exists( PATH_IN_CONSTANT . '/file.txt' );
    //     },
    // ],


    // "database" => [
    //     "error_message" => "les coordonnées de la base de données ne sont pas renseigné",
    //     "callback" => function() {
    //         return 0;
    //     },
    // ],

];

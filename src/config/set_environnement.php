<?php

use Env\Env;

/**
 * Ce fichier de constante est codé de manière à être rappelé régulièrement, en fin de script notamment
 * afin d'actualiser les valeurs des constantes qui n'existeraient pas encore,
 * et ce de manière à prendre en compte les ajouts au projet que l'exécution des différents script aurait pû réaliser.
 */

$env = Env::getInstance();

if( !$env->isset("DS")) {
    $env->set( "DS", DIRECTORY_SEPARATOR);
}

// Chemin vers la racine de ljd-cli.phar
if( !$env->isset("LJD_CLI_ROOT") ) {
    $env->set( "LJD_CLI_ROOT", dirname( __DIR__ ) );
}

// Chemin vers les vendors de ljd-cli.phar
if( !$env->isset("VENDOR_DIR") ) {
    $env->set( "VENDOR_DIR", LJD_CLI_ROOT . '/vendor' );
}

// Chemin ver le répertoire de l'outil Validator de ljd-cli.phar
if( !$env->isset("VALIDATOR_DIR") ) {
    $env->set( "VALIDATOR_DIR", LJD_CLI_ROOT . '/validator' );
}

// Chemin vers le répertoire de config de ljd-cli.phar
if( !$env->isset("CONFIG_DIR") ) {
    $env->set( "CONFIG_DIR", LJD_CLI_ROOT . '/config' );
}

// Chemin vers le répétoire de l'outil Menu de ljd-cli.phar
if( !$env->isset("MENU_DIR") ) {
    $env->set( "MENU_DIR", LJD_CLI_ROOT . '/menu' );
}

// Chemin vers le répertoire des scripts de ljd-cli.phar
if( !$env->isset("SCRIPT_DIR") ) {
    $env->set( "SCRIPT_DIR", LJD_CLI_ROOT . '/script' );
}

// Chemin (commençant par phar://) vers la racine du projet (le répertoire dans lequel se trouve ljd-cli.phar)
if( !$env->isset("PROJECT_ROOT_WITH_PHAR") ) {
    $env->set( "PROJECT_ROOT_WITH_PHAR", dirname( __DIR__, 2 ) );
}

// Chemin (sans phar://) vers la racine du projet (le répertoire dans lequel se trouve ljd-cli.phar)
if( !$env->isset("PROJECT_ROOT") ) {
    $env->set( "PROJECT_ROOT", str_replace( "phar://", "", PROJECT_ROOT_WITH_PHAR ) );
}

/* Define STDIN in case if it is not already defined by PHP for some reason */
if( !$env->isset("STDIN") ) {
    $env->set("STDIN", fopen('php://stdin','r'));
}
if( !$env->isset("STDOUT") ) {
    $env->set("STDOUT", fopen('php://stdout', 'w'));
}
if( !$env->isset("STDERR") ) {
    $env->set("STDERR", fopen('php://stderr', 'w'));
}

// Congiguration supplémentaire si fichier de configuration créer et renseigné
if( file_exists( PROJECT_ROOT . '/config-for-ljd-cli.ini') ) {

    $project_config = parse_ini_file( PROJECT_ROOT . '/config-for-ljd-cli.ini');

    if( !empty($project_config["PROJECT_TYPE"]) && !$env->isset("PROJECT_TYPE") ) {
        $env->set( "PROJECT_TYPE", $project_config["PROJECT_TYPE"] );
    }

    if( !empty($project_config["THEME_NAME"]) && !$env->isset("THEME_NAME") ) {
        $env->set( "THEME_NAME", $project_config["THEME_NAME"] );
    }

    if( !empty($project_config["PHP_V"]) && !$env->isset("PHP_V") ) {
        $env->set( "PHP_V", $project_config["PHP_V"] );
    }

    if( PROJECT_TYPE == "iquitheme") {

        if( !$env->isset("CMS_PATH") ) {
            $env->set( "CMS_PATH", PROJECT_ROOT . "/htdocs/cms" );
        }
        if( !$env->isset("PLUGIN_PATH") ) {
            $env->set( "PLUGIN_PATH", PROJECT_ROOT . "/htdocs/content/plugins" );
        }
        if( !$env->isset("MU_PLUGIN_PATH") ) {
            $env->set( "MU_PLUGIN_PATH", PROJECT_ROOT . "/htdocs/content/mu-plugins" );
        }
        if( !$env->isset("THEMES_PATH") ) {
            $env->set( "THEMES_PATH", PROJECT_ROOT . "/htdocs/content/themes" );
        }
        if( !$env->isset("THEME_PATH") ) {
            $env->set( "THEME_PATH", THEMES_PATH . "/" . THEME_NAME );
        }

    } else if( PROJECT_TYPE == "loreto" ) {

        if( !$env->isset("CMS_PATH") ) {
            $env->set( "CMS_PATH", PROJECT_ROOT . "/web/wp" );
        }
        if( !$env->isset("PLUGIN_PATH") ) {
            $env->set( "PLUGIN_PATH", PROJECT_ROOT . "/web/app/plugins" );
        }
        if( !$env->isset("MU_PLUGIN_PATH") ) {
            $env->set( "MU_PLUGIN_PATH", PROJECT_ROOT . "/web/app/mu-plugins" );
        }
        if( !$env->isset("THEMES_PATH") ) {
            $env->set( "THEMES_PATH", PROJECT_ROOT . "/web/app/themes" );
        }
        if( !$env->isset("THEME_PATH") ) {
            $env->set( "THEME_PATH", THEMES_PATH . "/" . THEME_NAME );
        }

    }

}

// Débug :
// print_r(get_defined_constants(true)["user"]);die();

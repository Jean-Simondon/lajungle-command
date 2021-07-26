<?php

/**
 * Ce fichier de constante est codé de manière à être rappelé régulièrement, en fin de script notamment
 * afin d'actualiser les valeurs des constantes qui n'existeraient pas encore,
 * et ce de manière à prendre en compte les ajouts au projet que l'exécution des différents script aurait pû réaliser.
 */

if( !defined("DS")) {
    define( "DS", DIRECTORY_SEPARATOR);
}

// Chemin vers la racine de ljd-cli.phar
if( !defined("LJD_CLI_ROOT") ) {
    define( "LJD_CLI_ROOT", dirname( __DIR__ ) );
}

// Chemin vers les vendors de ljd-cli.phar
if( !defined("VENDOR_DIR") ) {
    define( "VENDOR_DIR", LJD_CLI_ROOT . '/vendor' );
}

// Chemin ver le répertoire de l'outil Validator de ljd-cli.phar
if( !defined("VALIDATOR_DIR") ) {
    define( "VALIDATOR_DIR", LJD_CLI_ROOT . '/validator' );
}

// Chemin vers le répertoire de config de ljd-cli.phar
if( !defined("CONFIG_DIR") ) {
    define( "CONFIG_DIR", LJD_CLI_ROOT . '/config' );
}

// Chemin vers le répétoire de l'outil Menu de ljd-cli.phar
if( !defined("MENU_DIR") ) {
    define( "MENU_DIR", LJD_CLI_ROOT . '/menu' );
}

// Chemin vers le répertoire des scripts de ljd-cli.phar
if( !defined("SCRIPT_DIR") ) {
    define( "SCRIPT_DIR", LJD_CLI_ROOT . '/script' );
}

// Chemin (commençant par phar://) vers la racine du projet (le répertoire dans lequel se trouve ljd-cli.phar)
if( !defined("PROJECT_ROOT_WITH_PHAR") ) {
    define( "PROJECT_ROOT_WITH_PHAR", dirname( __DIR__, 2 ) );
}

// Chemin (sans phar://) vers la racine du projet (le répertoire dans lequel se trouve ljd-cli.phar)
if( !defined("PROJECT_ROOT") ) {
    define( "PROJECT_ROOT", str_replace( "phar://", "", PROJECT_ROOT_WITH_PHAR ) );
}

/* Define STDIN in case if it is not already defined by PHP for some reason */
if( !defined("STDIN") ) {
    define("STDIN", fopen('php://stdin','r'));
}
if( !defined("STDOUT") ) {
    define("STDOUT", fopen('php://stdout', 'w'));
}
if( !defined("STDERR") ) {
    define("STDERR", fopen('php://stderr', 'w'));
}

// Congiguration supplémentaire si fichier de configuration créer et renseigné
if( file_exists( PROJECT_ROOT . '/config-for-ljd-cli.ini') ) {

    $project_config = parse_ini_file( PROJECT_ROOT . '/config-for-ljd-cli.ini');

    if( !empty($project_config["PROJECT_TYPE"]) && !defined("PROJECT_TYPE") ) {
        define( "PROJECT_TYPE", $project_config["PROJECT_TYPE"] );
    }

    if( !empty($project_config["THEME_NAME"]) && !defined("THEME_NAME") ) {
        define( "THEME_NAME", $project_config["THEME_NAME"] );
    }

    if( !empty($project_config["PHP_V"]) && !defined("PHP_V") ) {
        define( "PHP_V", $project_config["PHP_V"] );
    }

    if( PROJECT_TYPE == "iquitheme") {

        if( !defined("CMS_PATH") ) {
            define( "CMS_PATH", PROJECT_ROOT . "/htdocs/cms" );
        }
        if( !defined("PLUGIN_PATH") ) {
            define( "PLUGIN_PATH", PROJECT_ROOT . "/htdocs/content/plugins" );
        }
        if( !defined("MU_PLUGIN_PATH") ) {
            define( "MU_PLUGIN_PATH", PROJECT_ROOT . "/htdocs/content/mu-plugins" );
        }
        if( !defined("THEMES_PATH") ) {
            define( "THEMES_PATH", PROJECT_ROOT . "/htdocs/content/themes" );
        }
        if( !defined("THEME_PATH") ) {
            define( "THEME_PATH", THEMES_PATH . "/" . THEME_NAME );
        }

    } else if( PROJECT_TYPE == "loreto" ) {

        if( !defined("CMS_PATH") ) {
            define( "CMS_PATH", PROJECT_ROOT . "/web/wp" );
        }
        if( !defined("PLUGIN_PATH") ) {
            define( "PLUGIN_PATH", PROJECT_ROOT . "/web/app/plugins" );
        }
        if( !defined("MU_PLUGIN_PATH") ) {
            define( "MU_PLUGIN_PATH", PROJECT_ROOT . "/web/app/mu-plugins" );
        }
        if( !defined("THEMES_PATH") ) {
            define( "THEMES_PATH", PROJECT_ROOT . "/web/app/themes" );
        }
        if( !defined("THEME_PATH") ) {
            define( "THEME_PATH", THEMES_PATH . "/" . THEME_NAME );
        }

    }

}

// Débug :
// print_r(get_defined_constants(true)["user"]);die();

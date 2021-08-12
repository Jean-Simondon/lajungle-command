<?php

/**
 * Ce fichier de constante est codé de manière à être rappelé régulièrement, en fin de script notamment
 * afin d'actualiser les valeurs des constantes qui n'existeraient pas encore,
 * et ce de manière à prendre en compte les ajouts au projet que l'exécution des différents script aurait pû réaliser.
 */

//===========================================================================
//===========================================================================
//      GENERAL
//===========================================================================
//===========================================================================

// Le séparateur du système de fichier
if( !defined("DS") ) {
    define( "DS", DIRECTORY_SEPARATOR );
}


//===========================================================================
//===========================================================================
//      A PROPOS DU PACKAGE DE COMMAND
//===========================================================================
//===========================================================================

// Chemin vers la racine de lajungle-command
if( !defined("LJD_CMD_ROOT") ) {
    define( "LJD_CMD_ROOT", dirname( __DIR__, 2) );
}

// Chemin vers le dossier src du package lajungle-command
if( !defined("LJD_CMD_SRC_DIR") ) {
    define( "LJD_CMD_SRC_DIR", LJD_CMD_ROOT . "/src" );
}

// Chemin vers les vendors de lajungle-command
if( !defined("LJD_CMD_VENDOR_DIR") ) {
    define( "LJD_CMD_VENDOR_DIR", LJD_CMD_ROOT . '/vendor' );
}

// Chemin ver le répertoire de l'outil Validator de lajungle-command
if( !defined("LJD_CMD_VALIDATOR_DIR") ) {
    define( "LJD_CMD_VALIDATOR_DIR", LJD_CMD_SRC_DIR . '/validator' );
}

// Chemin vers le répertoire de config de lajungle-command
if( !defined("LJD_CMD_CONFIG_DIR") ) {
    define( "LJD_CMD_CONFIG_DIR", LJD_CMD_SRC_DIR . '/config' );
}

// Chemin vers le répétoire de l'outil Menu de lajungle-command
if( !defined("LJD_CMD_MENU_DIR") ) {
    define( "LJD_CMD_MENU_DIR", LJD_CMD_SRC_DIR . '/menu' );
}

// Chemin vers le répertoire des scripts de lajungle-command
if( !defined("LJD_CMD_SCRIPT_DIR") ) {
    define( "LJD_CMD_SCRIPT_DIR", LJD_CMD_SRC_DIR . '/script' );
}

// Chemin vers le répertoire des scripts de lajungle-command
if( !defined("LJD_CMD_SCRIPT_VENDOR_DIR") ) {
    define( "LJD_CMD_SCRIPT_VENDOR_DIR", LJD_CMD_SCRIPT_DIR . '/vendor' );
}

// Chemin (commençant par phar://) vers la racine du projet (le répertoire dans lequel se trouve lajungle-command)
// if( !defined("PROJECT_ROOT_WITH_PHAR") ) {
//     define( "PROJECT_ROOT_WITH_PHAR", dirname( __DIR__, 2 ) );
// }

// Chemin (sans phar://) vers la racine du projet (le répertoire dans lequel se trouve lajungle-command)
if( !defined("LJD_PROJECT_ROOT") && defined("WP_CLI_PHAR_PATH") ) {
    define( "LJD_PROJECT_ROOT", WP_CLI_PHAR_PATH );
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

//===========================================================================
//===========================================================================
//      A PROPOS DU PROJET
//===========================================================================
//===========================================================================

if( !defined("THEME_NAME") ) {
    define( "THEME_NAME", basename(STYLESHEETPATH) );
}

// if( !defined("THEME_NAME_CAMEL") ) {
//     define( "THEME_NAME", basename(STYLESHEETPATH) );
// }

// Congiguration supplémentaire si fichier de configuration créer et renseigné
if( defined("LJD_PROJECT_ROOT") && file_exists( LJD_PROJECT_ROOT . '/config-for-ljd-cli.ini') ) {

    $project_config = parse_ini_file( LJD_PROJECT_ROOT . '/config-for-ljd-cli.ini');

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

        // if( !defined("CMS_PATH") ) {
        //     define( "CMS_PATH", LJD_PROJECT_ROOT . "/htdocs/cms" );
        // }
        // if( !defined("PLUGIN_PATH") ) {
        //     define( "PLUGIN_PATH", LJD_PROJECT_ROOT . "/htdocs/content/plugins" );
        // }
        // if( !defined("MU_PLUGIN_PATH") ) {
        //     define( "MU_PLUGIN_PATH", LJD_PROJECT_ROOT . "/htdocs/content/mu-plugins" );
        // }
        // if( !defined("THEMES_PATH") ) {
        //     define( "THEMES_PATH", LJD_PROJECT_ROOT . "/htdocs/content/themes" );
        // }
        // if( !defined("STYLESHEETPATH") ) {
        //     define( "STYLESHEETPATH", THEMES_PATH . "/" . THEME_NAME );
        // }

    } else if( PROJECT_TYPE == "loreto" ) {

        // if( !defined("CMS_PATH") ) {
        //     define( "CMS_PATH", LJD_PROJECT_ROOT . "/web/wp" );
        // }
        // if( !defined("PLUGIN_PATH") ) {
        //     define( "PLUGIN_PATH", LJD_PROJECT_ROOT . "/web/app/plugins" );
        // }
        // if( !defined("MU_PLUGIN_PATH") ) {
        //     define( "MU_PLUGIN_PATH", LJD_PROJECT_ROOT . "/web/app/mu-plugins" );
        // }
        // if( !defined("THEMES_PATH") ) {
        //     define( "THEMES_PATH", LJD_PROJECT_ROOT . "/web/app/themes" );
        // }
        // if( !defined("STYLESHEETPATH") ) {
        //     define( "STYLESHEETPATH", THEMES_PATH . "/" . THEME_NAME );
        // }

    }

}

// Débug :
// print_r(get_defined_constants(true)["user"]);die();


// constante utile quand wp-cli :
/**
 *  EXEMPLE AVEC LE PROJET TANDEM
 * 
 * [WP_CLI_PHAR_PATH] => /Users/mbpdejean/workspace/tandem
 * [ABSPATH] => /Users/mbpdejean/workspace/tandem/htdocs/cms/
 * [DB_NAME] => tandem
 * [DB_USER] => root
 * [DB_PASSWORD] => root
 * [DB_HOST] => localhost
 * [WP_HOME] => https://tandem.lan
 * [WP_SITEURL] => https://tandem.lan/cms
 * THEMOSIS_STORAGE
 * [CONTENT_DIR] => content
 * [WP_CONTENT_DIR] => /Users/mbpdejean/workspace/tandem/htdocs/content
 * [WP_CONTENT_URL] => https://tandem.lan/content
 * [WP_LANG_DIR] => /Users/mbpdejean/workspace/tandem/htdocs/content/languages
 * [LANGDIR] => wp-content/languages
 * [WP_PLUGIN_DIR] => /Users/mbpdejean/workspace/tandem/htdocs/content/plugins
 * [WP_PLUGIN_URL] => https://tandem.lan/content/plugins
 * [PLUGINDIR] => wp-content/plugins
 * 
 * [SITECOOKIEPATH] => /cms/
 * [ADMIN_COOKIE_PATH] => /cms/wp-admin
 * [PLUGINS_COOKIE_PATH] => /content/plugins
 * 
 * [LJD_CLI_ROOT] => /Users/mbpdejean/.wp-cli/packages/vendor/jean-simondon/lajungle-command
 * [VENDOR_DIR] => /Users/mbpdejean/.wp-cli/packages/vendor/jean-simondon/lajungle-command/vendor
 * [VALIDATOR_DIR] => /Users/mbpdejean/.wp-cli/packages/vendor/jean-simondon/lajungle-command/validator
 * [CONFIG_DIR] => /Users/mbpdejean/.wp-cli/packages/vendor/jean-simondon/lajungle-command/config
 * [MENU_DIR] => /Users/mbpdejean/.wp-cli/packages/vendor/jean-simondon/lajungle-command/menu
 * [SCRIPT_DIR] => /Users/mbpdejean/.wp-cli/packages/vendor/jean-simondon/lajungle-command/script
 * [PROJECT_ROOT_WITH_PHAR] => /Users/mbpdejean/.wp-cli/packages/vendor/jean-simondon
 * [PROJECT_ROOT] => /Users/mbpdejean/.wp-cli/packages/vendor/jean-simondon
 * 
 */
<?php

use Validator\Validator;

Validator::getInstance()
    ->require([
        "project_is_blank",
    ]);

$this->display("Bienvenue dans l'installation de votre projet Wordpress - Loreto");

    // ->display("Test des pré-requis :")
    // ->display("Vérification de l'installation de WGET")->validateTool("wget");

// if ($this->get("wget") == true) :
//     $this->display("wget... ok");
// else :
//     $this->display("WGET est obligatoire, merci de l'installer avant de recommencer l'installation !")
//         ->endScript();
// endif;

$this->display("Vérification de l'installation de TAR")->validateTool("tar");

// if ($this->get("tar") == true) :
//     $this->display("tar... ok");
// else :
//     $this->else("tar")
//         ->display("TAR est obligatoire, merci de l'installer avant de recommencer l'installation !")
//         ->endScript();
// endif;

// $this->display("Avant de commencer, j'ai besoin de quelques informations");

    // ->display("Outils d'assets (gulp, npm install, etc) [OoYy/Nn] : ")->askInputYesOrNo("WITH_ASSETS");

// if ($this->get("WITH_ASSETS") == false) :
//     $this->set("ASSETS", false)
//         ->set("ASSETSTXT", false);
// endif;

// Si BDD sur serveur jakku
// $this->display("Serveur Jakku [OoYy/Nn] : ")->askInputYesOrNo("IS_JAKKU");

// if ($this->get("IS_JAKKU") == false) :
    $this->display("Serveur BDD :")->askInputText("DB_HOST")
        ->display("Utilisateur BDD :")->askInputText("DB_USER")
        ->display("Mot de passe BDD")->askInputText("DB_PASSWORD");
// endif;

// Info supplémentaire :
$this->display("Nom de la base : ")->askInputText("DB_NAME")
    ->display("Adresse locale du site : ")->askInputText("WP_HOME")
    ->display("Nom du thème : ")->askInputText("THEME_NAME")

    // Suppression des "-" et "_"
    ->set("THEME_NAME", str_replace("-", "", $this->get("THEME_NAME")))
    ->set("THEME_NAME", str_replace("_", "", $this->get("THEME_NAME")))

    // Récapitulatif
    ->display("Récapitulatif : ")
    ->display("Nom de la base : " . $this->get("DB_NAME"))
    ->display("Adresse : " . $this->get("WP_HOME"))
    ->display("Nom du thème : " . $this->get("THEME_NAME"))
    // ->display("Installation des assets : " . ( !empty($this->get("ASSETSTXT")) && $this->get("ASSETSTXT") ? "Oui" : "Non" ) )

    // Est-ce que l'on continue ?
    ->display("Continuer [OoYy/Nn] : ")->askInputYesOrNo("CONTINUE");

if ($this->get("CONTINUE") == false) :
    $this->endScript();
endif;

    define( "THEME_NAME", $this->get("THEME_NAME"));



    // $this->display("Récupération des données (scripts de déploiement, configuration etc.)")
    /**
     * TO DO :
     * téléchargement des fichiers de configuration, si nécessaire
     */



    $this->display("Installation Bedrock")

        ->shell_exec("composer create-project roots/bedrock")
        ->shell_exec("cd " . $project_root . "/ && mv bedrock/* ./")
        ->shell_exec("cd " . $project_root . "/ && mv bedrock/.* ./")
        ->shell_exec("cd " . $project_root . "/ && rm -Rf bedrock");

        /**
         * Création des constantes propre à la structure d'un projet loreto
         */
        if( !defined("CMS_PATH")):
            define( "CMS_PATH", PROJECT_ROOT . "/web/wp" );
        endif;
        if( !defined("PLUGIN_PATH")):
            define( "PLUGIN_PATH", PROJECT_ROOT . "/web/app/plugins" );
        endif;
        if( !defined("MU_PLUGIN_PATH")):
            define( "MU_PLUGIN_PATH", PROJECT_ROOT . "/web/app/mu-plugins" );
        endif;
        if( !defined("THEMES_PATH")):
            define( "THEMES_PATH", PROJECT_ROOT . "/web/app/themes" );
        endif;

    $this->display("Customisation du composer")

        ->shell_exec("composer config repositories. composer " . LJD_COM_REPO)
        ->shell_exec('composer config --json extra.installer-paths \'{"web/app/mu-plugins/{$name}/": ["type:wordpress-muplugin","lajungle/advanced-custom-fields-pro", "wpackagist-plugin/stream"], "web/app/plugins/{$name}/": ["type:wordpress-plugin"], "web/app/themes/{$name}/": ["type:wordpress-theme"] }\'')

    ->display("Ajout de dépendances")

        // Packagist
        ->shell_exec("composer require 'filp/whoops:2.13' --no-update;")
        ->shell_exec("composer require 'illuminate/database:8.49' --no-update;")
        ->shell_exec("composer require 'monolog/monolog:2.2' --no-update;")
        ->shell_exec("composer require 'mobiledetect/mobiledetectlib:2.8.37' --no-update;")
        ->shell_exec("composer require 'wordplate/acf:8.6.0' --no-update;")

        // La Jungle
        ->shell_exec("composer require 'lajungle/acf-pro' --no-update;")
        ->shell_exec("composer require 'lajungle/wp-rocket' --no-update;")
        ->shell_exec("composer require 'lajungle/gravityforms' --no-update;")
        ->shell_exec("composer require 'lajungle/ljd-mu-plugins' --no-update;")
        ->shell_exec("composer require 'lajungle/webtoffee-gdpr-cookie-consent' --no-update;")
        // ->shell_exec("composer require 'lajungle/iquitos' --no-update;")
        // ->shell_exec("composer require 'lajungle/ignition' --no-update;")
        // ->shell_exec("composer require 'lajungle/iquitheme' --no-update;")

        // WPackagist 
        ->shell_exec("composer require 'wpackagist-plugin/wordpress-seo' --no-update;")
        ->shell_exec("composer require 'wpackagist-plugin/crop-thumbnails' --no-update;")
        ->shell_exec("composer require 'wpackagist-plugin/regenerate-thumbnails' --no-update;")
        ->shell_exec("composer require 'wpackagist-plugin/post-type-archive-links' --no-update;")

        // Mise à jour du composer
        ->shell_exec("composer update")

    // ->display("Installation Multi environnement")
        /**
         * TO DO : Chercher voir à quoi ressemble les fichier d'environnement sur les projets loreto
         */

        // ->exec("cd " . $project_root . "/ && rm config/environment.php")
        // ->exec("cd " . $project_root . "/ && mv tmp/environment.php config/")
        // ->exec("cd " . $project_root . "/ && rm config/environments/*.php")
        // ->exec("cd " . $project_root . "/ && mv tmp/local.php config/environments/")
        // ->exec("cd " . $project_root . "/ && cp config/environments/local.php config/environments/dev.php")
        // ->exec("cd " . $project_root . "/ && mv tmp/production.php config/environments/")
        // ->exec("cd " . $project_root . "/ && cp config/environments/production.php config/environments/preprod.php")



    ->display("Installation de Sage")

        ->askInputNumber(
            "Comment voulez-vous installer Sage ?",
            [
                '1' => 'Ajout dans le composer en tant que dépendances',
                '2' => 'composer create-project roots/sage dans le répertoire de thème'
            ],
            "SAGE_INSTALL_MODE"
        );

        if( $this->get("SAGE_INSTALL_MODE") == "Ajout dans le composer en tant que dépendances"):

            $this->display("Attention !")->display("cette solution semble poser des problèmes en matière de controller App ( erreur Class 'App' not found ) ")
                ->shell_exec("composer require 'roots/sage:9.0.0'")
                ->shell_exec("composer update");

        elseif( $this->get("SAGE_INSTALL_MODE") == 'composer create-project roots/sage dans le répertoire de thème'):

            $this->shell_exec("cd " . THEMES_PATH . "/ && composer create-project roots/sage " . THEME_NAME . " dev-master");

        endif;

            if( !defined("THEME_PATH")):
                define( "THEME_PATH", THEMES_PATH . "/" . THEME_NAME );
            endif;
-
            $this->shell_exec("cd " . THEMES_PATH . "/ && composer install")
                ->shell_exec("cd " . THEMES_PATH . "/ && yarn")
                // ->shell_exec("cd " . THEMES_PATH . "/ && yarn & yarn build")
                // ->shell_exec("cd " . THEMES_PATH . "/ && yarn build:production")

    // Supprimer les thèmes classiques

        ->shell_exec("rm -Rf " . CMS_PATH . "/wp-content/themes/*");

    // Installer Webpack ou update webpack.mix.js avec URL dev

        // https://webpack.js.org/guides/installation/

        /**
         * Changer les variables dans le fichier du theme
         */


    // Install de wp-cli et install wordpress

    $this->display("Installation WP_CLI")

        ->shell_exec('cd ' . $project_root . '/ && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar')

        ->display("Initialisation BDD & sélection du thème")
        ->shell_exec('cd ' . $project_root . '/ && php wp-cli.phar core install --url="' . $this->get("WP_HOME") . '" --title="' . $this->get("CAMEL") . '" --admin_user="' . $this->get("WP_USER") . '" --admin_password="' . $this->get("WP_PASSWORD") . '" --admin_email="' . $this->get("WP_EMAIL") . '" --skip-email')
        ->shell_exec('cd ' . $project_root . '/ && php wp-cli.phar theme activate ' . $this->get("THEME_NAME"))
        ->shell_exec('cd ' . $project_root . '/ && php wp-cli.phar language core install fr_FR')
        ->shell_exec('cd ' . $project_root . '/ && php wp-cli.phar site switch-language fr_FR')
        // ->shell_exec('cd ' . $project_root . ' && php wp-cli.phar reset-cookieyes --activate')


    // Nettoyage

    ->display("Déplacement des fichiers de scripts et ménage")

        ->shell_exec('cd ' . $project_root . '/ && mv tmp/*.sh ./')
        ->shell_exec('cd ' . $project_root . '/ && mv tmp/*.txt ./')
        ->shell_exec('cd ' . $project_root . '/ && rm -Rf tmp')

        ->display("Vous pouvez maintenant utiliser " . $this->get("WP_HOME"));

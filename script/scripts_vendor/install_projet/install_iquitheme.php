<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([
    "project_is_blank",
]);

$project_root = str_replace( " " , "\ " , PROJECT_ROOT);

$this->setArgs([
    "DB_HOST" => JAKKU_HOST,
    "DB_USER" => "root",
    "DB_PASSWORD" => "lajungle",
    "DB_NAME" => "",
    "WP_HOME" => "",
    "WP_EMAIL" => "webmaster@lajungle.fr",
    "WP_USER" => "admin",
    "WP_PASSWORD" => "admin",
    "ASSETS" => 1,
    "ASSETSTXT" => true,
]);

$this->display("Bienvenue dans l'installation de votre projet Wordpress")
    ->display("Test des pré-requis :")

    ->display("Vérification de l'installation de WGET")->validateTool("wget");

if ($this->get("wget") == true) :
    $this->display("wget... ok");
else :
    $this->display("WGET est obligatoire, merci de l'installer avant de recommencer l'installation !")
        ->endScript();
endif;

$this->display("Vérification de l'installation de TAR")->validateTool("tar");

if ($this->get("tar") == true) :
    $this->display("tar... ok");
else :
    $this->else("tar")
        ->display("TAR est obligatoire, merci de l'installer avant de recommencer l'installation !")
        ->endScript();
endif;

$this->display("Avant de commencer, j'ai besoin de quelques informations")

    ->display("Outils d'assets (gulp, npm install, etc) [OoYy/Nn] : ")->askInputYesOrNo("WITH_ASSETS");

if ($this->get("WITH_ASSETS") == false) :
    $this->set("ASSETS", false)
        ->set("ASSETSTXT", false);
endif;

// Si BDD sur serveur jakku
$this->display("Serveur Jakku [OoYy/Nn] : ")->askInputYesOrNo("IS_JAKKU");

if ($this->get("IS_JAKKU") == false) :
    $this->display("Serveur BDD :")->askInputText("DB_HOST")
        ->display("Utilisateur BDD :")->askInputText("DB_USER")
        ->display("Mot de passe BDD")->askInputText("DB_PASSWORD");
endif;

// Info supplémentaire :
$this->display("Nom de la base : ")->askInputText("DB_NAME")
    ->display("Adresse locale du site : ")->askInputText("WP_HOME")
    ->display("Nom du thème :")->askInputText("THEME_NAME")

    // Suppression des "-" et "_"
    ->set("THEME_NAME", str_replace("-", "", $this->get("THEME_NAME")))
    ->set("THEME_NAME", str_replace("_", "", $this->get("THEME_NAME")))

    // Récapitulatif
    ->display("Récapitulatif : ")
    ->display("Nom de la base : " . $this->get("DB_NAME"))
    ->display("Adresse : " . $this->get("WP_HOME"))
    ->display("Nom du thème : " . $this->get("THEME_NAME"))
    ->display("Installation des assets : " . ( !empty($this->get("ASSETSTXT")) && $this->get("ASSETSTXT") ? "Oui" : "Non" ) )

    // Est-ce que l'on continue ?
    ->display("Continuer [OoYy/Nn] : ")->askInputYesOrNo("CONTINUE");

if ($this->get("CONTINUE") == false) :
    $this->endScript();
endif;

$this->display("Récupération des données (scripts de déploiement, configuration etc.)")
    ->exec("cd " . $project_root . " && wget -q " . LJD_CDN)
    ->exec("cd " . $project_root . " && tar xzf scripts.v6.tar.gz")

    ->display("Installation Thémosis")

    ->exec("cd " . $project_root . "/ && composer create-project themosis/themosis=1.3 themosis")
    ->exec("cd " . $project_root . "/ && mv themosis/* ./")
    ->exec("cd " . $project_root . "/ && mv themosis/.[!.]* ./")
    ->exec("cd " . $project_root . "/ && rm -Rf themosis")
    ->exec("cd " . $project_root . "/ && mv tmp/composer.json ./")
    ->exec("cd " . $project_root . "/ && composer update")

    ->display("Mise en place multi-environnement")

    ->exec("cd " . $project_root . "/ && rm config/environment.php")
    ->exec("cd " . $project_root . "/ && mv tmp/environment.php config/")
    ->exec("cd " . $project_root . "/ && rm config/environments/*.php")
    ->exec("cd " . $project_root . "/ && mv tmp/local.php config/environments/")
    ->exec("cd " . $project_root . "/ && cp config/environments/local.php config/environments/dev.php")
    ->exec("cd " . $project_root . "/ && mv tmp/production.php config/environments/")
    ->exec("cd " . $project_root . "/ && cp config/environments/production.php config/environments/preprod.php")

    ->replaceStringInFile($project_root . "/", ".env.local", "database-name", "DB_NAME")
    ->replaceStringInFile($project_root . "/", ".env.local", "database-user", "DB_USER")
    ->replaceStringInFile($project_root . "/", ".env.local", "database-password", "DB_PASSWORD")
    ->replaceStringInFile($project_root . "/", ".env.local", "localhost", "DB_HOST")
    ->replaceStringInFile($project_root . "/", ".env.local", "http://domain.tld", "WP_HOME")

    ->exec("cd " . $project_root . "/ && cp tmp/env .env.dev")
    ->exec("cd " . $project_root . "/ && cp tmp/env .env.preprod")
    ->exec("cd " . $project_root . "/ && cp tmp/env .env.production")

    ->exec("cd " . $project_root . "/ && rm htdocs/content/mu-plugins/load.php")
    ->exec("cd " . $project_root . "/ && mv tmp/load.php htdocs/content/mu-plugins/")
    ->exec("cd " . $project_root . "/ && rm .gitignore && mv tmp/.gitignore ./")

    ->display("Installation du Starter-Theme")

    ->exec("cd " . $project_root . "/ && mkdir htdocs/content/themes/starter-theme")
    ->exec("cd " . $project_root . "/ && git clone " . LJD_BITBUCKET)
    ->exec("cd " . $project_root . "/ && rm -Rf htdocs/content/themes/starter-theme/.git");

// On crée la constante menant droit au répertoire des thèmes
define("THEME_DIR", $project_root . '/htdocs/content/themes');

$this->set("CAMEL", ucfirst($this->get("THEME_NAME")))

    ->display("Installation du thème : " . $this->get("THEME_NAME") . " (5 étapes)")
    ->exec('cd ' . THEME_DIR . '/ && find ./starter-theme -name "style.css" -maxdepth 1 |xargs perl -pi -e "s/Starter theme/' . $this->get("CAMEL") . '/g" 2>/dev/null')
    ->exec('cd ' . THEME_DIR . '/ && find ./starter-theme -name "style.css" -maxdepth 1 |xargs perl -pi -e "s/starter theme/' . $this->get("THEME_NAME") . '/g" 2>/dev/null')

    ->display("\t1. Traitement renommage starter-theme => " . $this->get("THEME_NAME"))
    ->exec('cd ' . THEME_DIR . '/ && find ./starter-theme -name "*" |xargs perl -pi -e "s/starter-theme/' . $this->get("THEME_NAME") . '/g" 2>/dev/null')

    ->display('\t2. Traitement namespace Starter => ' . $this->get("CAMEL"))
    ->exec('cd ' . THEME_DIR . '/ && find ./starter-theme -name "*" |xargs perl -pi -e "s/Starter/' . $this->get("CAMEL") . '/g" 2>/dev/null')

    ->display('\t3. Installation dossier starter-theme => ' . $this->get("THEME_NAME"))
    ->exec('cd ' . THEME_DIR . '/ && mv ./starter-theme ./' . $this->get("THEME_NAME"));

if ($this->get("ASSETS") == true) :
    $this->display("Installation Gulp")
        ->exec('cd ' . THEME_DIR . '/' . $this->get("THEME_NAME") . ' && npm install gulp --silent')
        ->exec('cd ' . THEME_DIR . '/' . $this->get("THEME_NAME") . ' && npm install --silent')
        ->display("t4. Lancement gulp")
        ->exec('cd ' . THEME_DIR . '/' . $this->get("THEME_NAME") . ' && gulp')
        ->display("\t5. Lancement bower")
        ->exec('cd ' . THEME_DIR . '/' . $this->get("THEME_NAME") . ' && bower install');
endif;

$this->display("Installation WP_CLI")
    ->exec('cd ' . $project_root . '/ && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar')

    ->display("Initialisation BDD & sélection du thème")
    ->exec('cd ' . $project_root . '/ && php wp-cli.phar core install --url="' . $this->get("WP_HOME") . '" --title="' . $this->get("CAMEL") . '" --admin_user="' . $this->get("WP_USER") . '" --admin_password="' . $this->get("WP_PASSWORD") . '" --admin_email="' . $this->get("WP_EMAIL") . '" --skip-email')
    ->exec('cd ' . $project_root . '/ && php wp-cli.phar theme activate ' . $this->get("THEME_NAME"))
    ->exec('cd ' . $project_root . '/ && php wp-cli.phar language core install fr_FR')
    ->exec('cd ' . $project_root . '/ && php wp-cli.phar site switch-language fr_FR')
    // ->exec('cd ' . $project_root . ' && php wp-cli.phar reset-cookieyes --activate')

    ->display("Déplacement des fichiers de scripts et ménage")

    ->exec('cd ' . $project_root . '/ && mv tmp/*.sh ./')
    ->exec('cd ' . $project_root . '/ && mv tmp/*.txt ./')
    ->exec('cd ' . $project_root . '/ && rm -Rf tmp')
    ->exec('cd ' . $project_root . '/ && rm scripts.v6.tar.gz')

    ->display("Vous pouvez maintenant utiliser " . $this->get("WP_HOME"));





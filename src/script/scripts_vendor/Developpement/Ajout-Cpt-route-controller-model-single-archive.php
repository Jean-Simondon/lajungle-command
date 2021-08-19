<?php

// namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

/**
 * Créer un fichier de config et faire itérer dessus
 * pour toutes les constantes à créer
 */

$this->display("Bienvenue dans l'assistant de création de CPT")

    ->display("Quel est le slug du Cpt ?")
    ->askInputText("SLUG")

    ->display("Quel est le nom pluriel du Cpt ?")
    ->askInputText("PLURAL")

    ->display("Quel est le nom singulier du Cpt ?")
    ->askInputText("SINGULAR")

    // ->askInputKeyInArray(
    //     "Nom féminin ou masculin ?",
    //     [
    //         '1' => 'Masculin',
    //         '2' => 'Feminin',
    //     ],
    //     "GENRE"
    // )

    // ->display("Ajout de la route single et archive pour ce CPT ? [OoYy/Nn]")
    // ->askInputYesOrNo("ROUTE")

    ->display("Ajout d'un controller et model pour ce CPT ? [OoYy/Nn]")
    ->askInputYesOrNo("CONTROLLER")

    ->display("Ajout des templates single et archive pour ce CPT ? [OoYy/Nn]")
    ->askInputYesOrNo("TEMPLATE")

    ->display("Ajout d'un controller ajax")
    ->askInputYesOrNo("AJAX-CONTROLLER")

    ->display("Ajout d'une feature ACF pour déclarer des champs avec wordplate/Acf ? [OoYy/Nn]")
    ->askInputYesOrNo("ACF-FEATURE")

    ->display("Ajouter un fichier de script javascript pour la pagination ajax ? [OoYy/Nn]")
    ->askInputYesOrNo("AJAX-PAGINATION-JS");



$BUNDLE_REPO = LJD_CMD_ROOT . "/code_snippet/bundle/Route-cpt-acf-taxo-controller-single-archive";


/**
* Ajout du fichier Faetures > CPT > Cpt .... .php
*/
if( file_exists( $BUNDLE_REPO . "/features/cpt/CptExample.php" ) ) {
    if( file_exists( STYLESHEETPATH . '/resources/features/cpt/Cpt' . ucfirst($this->get("SLUG")) . '.php' )) {
        // Pour ne pas écraser le fichier s'il exisrte
        $this->display("Le fichier  dans Features > Cpt existe déjà");
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/resources/features/cpt/")) {
            $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/features/cpt/", false);
        }
        $this->display("Création du fichier Cpt")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $BUNDLE_REPO . "/features/cpt/CptExample.php " . STYLESHEETPATH . "/resources/features/cpt/CptExample.php", false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null', false)
        // renommage du fichier
        ->shell_exec('mv ' . STYLESHEETPATH . '/resources/features/cpt/CptExample.php ' . STYLESHEETPATH . '/resources/features/cpt/Cpt' . ucfirst($this->get("SLUG")) . '.php' , false);
    }
}


/**
* Ajout du controller
*/
if( $this->get("CONTROLLER") && file_exists( $BUNDLE_REPO . "/controllers/ExampleController.php" ) ) {

    if( file_exists( STYLESHEETPATH . '/resources/controllers/' . ucfirst($this->get("SLUG")) . 'Controller.php'  ) ) {
        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le fichier dans Ressources > Controllers existe déjà");
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists( STYLESHEETPATH . "/resources/controllers/") ) {
            $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/controllers/", false);
        }
        $this->display("Création du fichier Controller")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $BUNDLE_REPO . "/controllers/ExampleController.php " . STYLESHEETPATH . "/resources/controllers/ExampleController.php", false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null', false)
        // renommage du fichier
        ->shell_exec('mv ' . STYLESHEETPATH . '/resources/controllers/ExampleController.php ' . STYLESHEETPATH . '/resources/controllers/' . ucfirst($this->get("SLUG") . 'Controller.php' ), false);
    }

    if( file_exists( STYLESHEETPATH . '/resources/models/' . ucfirst($this->get("SLUG")) . 'Model.php'  ) ) {
        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le fichier dans Ressources > Models existe déjà");
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/resources/models/")) {
            $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/models/", false);
        }
        $this->display("Création du fichier Model")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $BUNDLE_REPO . "/models/ExampleModel.php " . STYLESHEETPATH . "/resources/models/ExampleModel.php", false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/models/ && find . -name "ExampleModel.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/models/ && find . -name "ExampleModel.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/models/ && find . -name "ExampleModel.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/models/ && find . -name "ExampleModel.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/models/ && find . -name "ExampleModel.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null', false)
        // renommage du fichier
        ->shell_exec('mv ' . STYLESHEETPATH . '/resources/models/ExampleModel.php ' . STYLESHEETPATH . '/resources/models/' . ucfirst($this->get("SLUG") . 'Model.php' ), false);
    }

}



/*
* Ajout de la page single
*/
if( $this->get("TEMPLATE") && file_exists( $BUNDLE_REPO . "/views/pages/single/single-example.blade.php" ) ) {
    if( file_exists(STYLESHEETPATH . '/resources/views/pages/single/single-' . $this->get("SLUG") . '.blade.php')) {
        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le ficher dans Views > Pages > Single existe déjà");        
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/resources/views/pages/single/")) {
            $this->display("Création du répertoire Views > Page > Single")
            ->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/views/pages/single/", false);
        }
        $this->display("Création du fichier Views > Page > Single")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $BUNDLE_REPO . "/views/pages/single/single-example.blade.php " . STYLESHEETPATH . "/resources/views/pages/single/single-example.blade.php", false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null', false)
        // Renommage du fichier
        ->shell_exec('mv ' . STYLESHEETPATH . '/resources/views/pages/single/single-example.blade.php ' . STYLESHEETPATH . '/resources/views/pages/single/single-' . $this->get("SLUG") . '.blade.php' , false);
    }
}


/**
 * Installation du template d'archive
 */
if( $this->get("TEMPLATE") && file_exists( $BUNDLE_REPO . "/views/pages/archive/archive-example.blade.php" ) ) {
    if( file_exists( STYLESHEETPATH . '/resources/views/pages/archive/archive-' . $this->get("SLUG") . '.blade.php' )) {
        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le ficher dans Views > Page > Archive existe déjà");
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/resources/views/pages/archive/")) {
            $this->display("Création du répertoire Views > Page > Archive")
            ->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/views/pages/archive/", false);
        }
        $this->display("Création du fichier Views > Pages > Archive")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $BUNDLE_REPO . "/views/pages/archive/archive-example.blade.php " . STYLESHEETPATH . "/resources/views/pages/archive/archive-example.blade.php", false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null', false)
        // renommage du fichier
        ->shell_exec('mv ' . STYLESHEETPATH . '/resources/views/pages/archive/archive-example.blade.php ' . STYLESHEETPATH . '/resources/views/pages/archive/archive-' . $this->get("SLUG") . '.blade.php', false);
    }
}


/**
 * Installation de card-example
 */
if( $this->get("TEMPLATE") && file_exists( $BUNDLE_REPO . "/views/elements/card-example.blade.php" ) ) {
    if( file_exists( STYLESHEETPATH . '/resources/views/elements/card-' . $this->get("SLUG") . '.blade.php' )) {
        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le ficher dans Views > Element existe déjà");        
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/resources/views/elements/")) {
            $this->display("Création du répertoire Views > Element")
            ->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/views/elements/", false);
        }
        // Copie du fichier depuis le catalogue
        $this->shell_exec("cp " . $BUNDLE_REPO . "/views/elements/card-example.blade.php " . STYLESHEETPATH . "/resources/views/elements/card-example.blade.php", false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null', false)
        // renommage du fichier
        ->shell_exec('mv ' . STYLESHEETPATH . '/resources/views/elements/card-example.blade.php ' . STYLESHEETPATH . '/resources/views/elements/card-' . $this->get("SLUG") . '.blade.php' , false);
    }
}


/**
 * Installation de la popin
 */
if( $this->get("TEMPLATE") && file_exists( $BUNDLE_REPO . "/views/elements/popin-example.blade.php" ) ) {
    if( file_exists( STYLESHEETPATH . '/resources/views/elements/popin-' . $this->get("SLUG") . '.blade.php' )) {
        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le ficher dans Views > Element existe déjà");
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/resources/views/elements/")) {
            $this->display("Création du répertoire Views > Element")
            ->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/views/elements/", false);
        }
        // Copie du fichier depuis le catalogue

        $this->shell_exec("cp " . $BUNDLE_REPO . "/views/elements/popin-example.blade.php " . STYLESHEETPATH . "/resources/views/elements/popin-example.blade.php", false)
        // Renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null', false)
        // Renommage du fichier
        ->shell_exec('mv ' . STYLESHEETPATH . '/resources/views/elements/popin-example.blade.php ' . STYLESHEETPATH . '/resources/views/elements/popin-' . $this->get("SLUG") . '.blade.php' , false);
    }
}




/**
* Ajout du fichier Faetures > acf >  ACF ....  .php
*/
if( $this->get("ACF-FEATURE") && file_exists( $BUNDLE_REPO . "/features/acf/ACFExample.php" ) ) {
    if( file_exists( STYLESHEETPATH . '/resources/features/acf/ACF' . ucfirst($this->get("SLUG")) . '.php' )) {
        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le fichier  dans Features > Acf existe déjà");
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/resources/features/acf/")) {
            $this->display("Création du répertoire Ressources > Features > Acf ")
            ->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/features/acf/", false);
        }
        $this->display("Création du fichier Acf")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $BUNDLE_REPO . "/features/acf/ACFExample.php " . STYLESHEETPATH . "/resources/features/acf/ACFExample.php", false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/acf/ && find . -name "ACFExample.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/acf/ && find . -name "ACFExample.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/acf/ && find . -name "ACFExample.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/acf/ && find . -name "ACFExample.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null', false)
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/acf/ && find . -name "ACFExample.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null', false)
        // renommage du fichier
        ->shell_exec('mv ' . STYLESHEETPATH . '/resources/features/acf/ACFExample.php ' . STYLESHEETPATH . '/resources/features/acf/ACF' . ucfirst($this->get("SLUG")) . '.php' , false);
    }
}





/**
 * Ajout du ControllerAjax
*/
if( $this->get("AJAX-CONTROLLER") && file_exists( $BUNDLE_REPO . "/controllers/AjaxListeController.php" ) ) {
    if( file_exists( STYLESHEETPATH . '/resources/controllers/AjaxListeController.php') ) {
        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le ficher AjaxListeController existe déjà");
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/resources/controllers/")) {
            $this->display("Création du répertoire Ressources > Controller ")
            ->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/controllers/", false);
        }
        $this->display("Création du fichier AjaxListeController")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $BUNDLE_REPO . "/controllers/AjaxListeController.php " . STYLESHEETPATH . "/resources/controllers/AjaxListeController.php", false)
        // renommage des placeholder dans le fichier
        ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "AjaxListeController.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null', false);
    }
}




/**
 * Ajout du ajax-pagination.js
 */
if( $this->get("AJAX-PAGINATION-JS") && file_exists( $BUNDLE_REPO . "/js/ajax-pagination.js" ) ) {
    if( file_exists( STYLESHEETPATH . '/resources/assets/js/src/ajax-pagination.js') ) {
        // Pour ne pas écraser le fichier s'il existe
        $this->display("Le fichier ajax-pagination.js existe déjà");
    } else {
        // Création du répertoire s'il n'existe pas déjà
        if( !file_exists(STYLESHEETPATH . "/resources/assets/js/src") ) {
            $this->display("Création du répertoire Ressources > Assets > js > src ")
            ->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/assets/js/src", false);
        }
        $this->display("Création du fichier ajax-pagination.js")
        // Copie du fichier depuis le catalogue
        ->shell_exec("cp " . $BUNDLE_REPO . "/js/ajax-pagination.js " . STYLESHEETPATH . "/resources/assets/js/src/ajax-pagination.js", false);
    }
}

;
/**
 * Dernière indication pour l'utisateur
 */
$this->display("Etape à réaliser manuellement :")
    ->display("Vous devez rajouter les routes dans le fichier config > routes")
    ->display("vous aurez certainement besoin de rajouter certain Helper comme PostHelper ou VarHelper");

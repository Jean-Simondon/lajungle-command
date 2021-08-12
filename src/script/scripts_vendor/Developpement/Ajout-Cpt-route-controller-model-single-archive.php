<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

/**
 * Créer un fichier de config et faire itérer dessus
 * pour toutes les constantes à créer
 */

$this->display("Bienvenue dans l'assistant de création de CPT")

    // ->display("Quel est le slug du Cpt ?")
    // ->askInputText("SLUG")
    ->set("SLUG", "actualite")

    // ->display("Quel est le nom pluriel du Cpt ?")
    // ->askInputText("PLURAL")
    ->set("PLURAL", "actualites")

    // ->display("Quel est le nom singulier du Cpt ?")
    // ->askInputText("SINGULAR")
    ->set("SINGULAR", "actualite")

    // ->display("Nom féminin ou masculin ?")
    // ->askInputKeyInArray(
    //     "",
    //     [
    //         '1' => 'Masculin',
    //         '2' => 'Feminin',
    //     ],
    //     "GENRE"
    // )

    ->display("Ajout de la route single et archive pour ce CPT ? [OoYy/Nn]")
    ->askInputYesOrNo("ROUTE")

    ->display("Ajout d'un controller pour ce CPT ? [OoYy/Nn]")
    ->askInputYesOrNo("CONTROLLER")

    ->display("Ajout des templates single et archive pour ce CPT ? [OoYy/Nn]")
    ->askInputYesOrNo("TEMPLATE")

    // ->display("Ajout d'un controller ajax")
    // ->askInputYesOrNo("AJAX-CONTROLLER")

    // ->display("Ajout d'une feature ACF pour déclarer des champs avec wordplate/Acf ? [OoYy/Nn]")
    // ->askInputYesOrNo("ACF-FEATURE")

    // ->display("Vous n'avez pas de fichier ajax-pagination.js, l'ajouter ? [OoYy/Nn]")
    // ->askInputYesOrNo("AJAX-PAGINATION")

;

$bundle_repo = LJD_CMD_ROOT . "/code_snippet/bundle/Route-cpt-acf-taxo-controller-single-archive";

/**
 * Ajout du fichier CPT
*/
if( $this->get("ROUTE") && file_exists( $bundle_repo . "/features/cpt/CptExample.php" ) ) {

    $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/features/cpt/")

    ->shell_exec("cp " . $bundle_repo . "/features/cpt/CptExample.php " . STYLESHEETPATH . "/resources/features/cpt/CptExample.php")
    
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/features/cpt/ && find . -name "CptExample.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null')

    ->shell_exec('mv ' . STYLESHEETPATH . '/resources/features/cpt/CptExample.php ' . STYLESHEETPATH . '/resources/features/cpt/Cpt' . ucfirst($this->get("SLUG") . '.php' ))

    ;
}


/**
 * Ajout de la route
*/
// if( file_exists( $bundle_repo . "/config/routes.config.php" ) ) {
//     print_r("installation de la route\n");
// }


// /**
// * Ajout du controller
// */
if( $this->get("CONTROLLER") && file_exists( $bundle_repo . "/controllers/ExampleController.php" ) ) {

    $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/controllers/")

    ->shell_exec("cp " . $bundle_repo . "/controllers/ExampleController.php " . STYLESHEETPATH . "/resources/controllers/ExampleController.php")

    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/controllers/ && find . -name "ExampleController.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null')

    ->shell_exec('mv ' . STYLESHEETPATH . '/resources/controllers/ExampleController.php ' . STYLESHEETPATH . '/resources/controllers/' . ucfirst($this->get("SLUG") . 'Controller.php' ))

    ;
}



// /*
// * Ajout des templates
// */
if( file_exists( $bundle_repo . "/views/pages/single/single-example.blade.php" ) ) {

    print_r("installation du template single\n");

    $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/views/pages/single/")

    ->shell_exec("cp " . $bundle_repo . "/views/pages/single/single-example.blade.php " . STYLESHEETPATH . "/resources/views/pages/single/single-example.blade.php")

    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/single/ && find . -name "single-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null')

    ->shell_exec('mv ' . STYLESHEETPATH . '/resources/views/pages/single/single-example.blade.php ' . STYLESHEETPATH . '/resources/views/pages/single/single-' . $this->get("SLUG") . '.blade.php' )

    ;

}

if( file_exists( $bundle_repo . "/views/pages/archive/archive-example.blade.php" ) ) {

    print_r("installation du template archive\n");

    $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/views/pages/archive/")

    ->shell_exec("cp " . $bundle_repo . "/views/pages/archive/archive-example.blade.php " . STYLESHEETPATH . "/resources/views/pages/archive/archive-example.blade.php")

    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/archive/ && find . -name "archive-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null')

    ->shell_exec('mv ' . STYLESHEETPATH . '/resources/views/pages/archive/archive-example.blade.php ' . STYLESHEETPATH . '/resources/views/pages/archive/archive-' . $this->get("SLUG") . '.blade.php' )

    ;

}


if( file_exists( $bundle_repo . "/views/pages/elements/card-example.blade.php" ) ) {

    print_r("installation du template single\n");

    $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/views/pages/elements/")

    ->shell_exec("cp " . $bundle_repo . "/views/pages/elements/card-example.blade.php " . STYLESHEETPATH . "/resources/views/pages/elements/card-example.blade.php")

    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "card-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null')

    ->shell_exec('mv ' . STYLESHEETPATH . '/resources/views/pages/elements/card-example.blade.php ' . STYLESHEETPATH . '/resources/views/pages/elements/card-' . $this->get("SLUG") . '.blade.php' )

    ;

}



if( file_exists( $bundle_repo . "/views/pages/elements/popin-example.blade.php" ) ) {

    print_r("installation du template single\n");

    $this->shell_exec('mkdir ' . STYLESHEETPATH . "/resources/views/pages/elements/")

    ->shell_exec("cp " . $bundle_repo . "/views/pages/elements/popin-example.blade.php " . STYLESHEETPATH . "/resources/views/pages/elements/popin-example.blade.php")

    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"YOUR_THEME_NAME"/' . ucfirst(THEME_NAME) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Example"/' . ucfirst($this->get("SLUG")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"Examples"/' . ucfirst($this->get("PLURAL")) . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"example"/' . $this->get("SLUG") . '/g" 2>/dev/null')
    ->shell_exec('cd ' . STYLESHEETPATH . '/resources/views/pages/elements/ && find . -name "popin-example.blade.php" -maxdepth 1 |xargs perl -pi -e "s/"examples"/' . $this->get("PLURAL") . '/g" 2>/dev/null')

    ->shell_exec('mv ' . STYLESHEETPATH . '/resources/views/pages/elements/popin-example.blade.php ' . STYLESHEETPATH . '/resources/views/pages/elements/popin-' . $this->get("SLUG") . '.blade.php' )

    ;

}


// /**
//  * Ajout du ajax-pagination.js
//  */
// if( file_exists( $bundle_repo . "/js/ajax-pagination.js" ) ) {
//     print_r("installation du js pagination ajax\n");
// }

// /**
//  * Ajout du ControllerAjax
// */
// if( file_exists( $bundle_repo . "/controllers/AjaxListController.php" ) ) {
//     print_r("installation du controller AJAX\n");
// }







 

;
/**
 * Stratégie
 * Pour chaque chois
 * 
 */
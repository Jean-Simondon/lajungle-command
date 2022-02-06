<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

// use Menu\Menu;
// use Menu\MenuDAO;
// use PhpSchool\CliMenu\Builder\CliMenuBuilder;

function run_forest() {

    require_once __DIR__ . '/src/index-for-command.php';

    // require_once __DIR__ . '/src/config/requirement.php';
    // require_once __DIR__ . '/src/environnement/Env.php';
    // // require __DIR__ . '/src/config/set_environnement.php';
    // require __DIR__ . '/src/config/constant.php';
    // require __DIR__ . '/src/config/private_constant.php';
    // require_once __DIR__ . '/src/config/loader.php';
    
    // ( new Menu( ( new MenuDAO() )->getConfigMenu(), new CliMenuBuilder()) )->getMenu()->open();
    
    // echo "Bye bye\n";

}

WP_CLI::add_command("run_forest", "run_forest");

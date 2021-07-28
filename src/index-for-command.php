#!/usr/bin/php -d display_errors=1
<?php declare(strict_types=1);

namespace Init;

// Si on veut utiliser des arguments :
    // if ($argc != 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
        // echo $_SERVER["argc"]."\n";
        // echo $_SERVER["argv"][0]."\n";

        // parser une commande dans $_GET
        // parse_str(implode('&', array_slice($argv, 1)), $_GET);
    // }

require_once __DIR__ . '/config/requirement.php';
require_once __DIR__ . '/environnement/Env.php';
// require __DIR__ . '/config/set_environnement.php';
require __DIR__ . '/config/constant.php';
require __DIR__ . '/config/private_constant.php';
require_once __DIR__ . '/config/loader.php';

use Menu\Menu;
use Menu\MenuDAO;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;

( new Menu( ( new MenuDAO() )->getConfigMenu(), new CliMenuBuilder()) )->getMenu()->open();

echo "Bye bye\n";
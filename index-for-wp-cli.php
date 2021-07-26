#!/usr/bin/php -d display_errors=1
<?php

namespace Init;

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

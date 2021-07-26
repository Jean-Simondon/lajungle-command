<?php declare(strict_types=1);

namespace Init;

require_once __DIR__ . '/config/requirement.php';
require_once __DIR__ . '/config/constant.php';
require_once __DIR__ . '/config/private_constant.php';
require_once __DIR__ . '/config/loader.php';

use Menu\Menu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;

( new Menu( $config_menu, new CliMenuBuilder()) )->getMenu()->open();

echo "Bye bye\n";

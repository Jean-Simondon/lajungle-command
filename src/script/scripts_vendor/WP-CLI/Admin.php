<?php

namespace Scripts;

use Validator\Validator;

// https://developer.wordpress.org/cli/commands/admin/

Validator::getInstance()->require([]);

$this->display("Ajout de dépendance")

    ->askInputKeyInArray(
        "Quel option utiliser ?",
        [
            '1' => 'EXIT',
            '2' => 'admin',
            '3' => 'admin --skip-themes',
            '4' => 'admin --debug',
            '5' => 'admin --prompt',
            '6' => 'admin --user=<id\|login\|email>',
        ],
        "REQUIRE"
    );

if( $this->get("REQUIRE") == "EXIT" ) {
    $this->dismiss();
}

$this->shell_exec("wp " + $this->get("REQUIRE"));

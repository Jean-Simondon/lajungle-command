<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

// https://developer.wordpress.org/cli/commands/package/

$this->display("Ajout de Packages CLI ")

    ->askInputKeyInArray(
        "Quel option utiliser ?",
        [
            '1' => 'EXIT',
            '2' => 'wp-cli/admin-command',
            '2' => '',
            '2' => '',
            '2' => '',
            '2' => '',
            '2' => '',
            '2' => '',
            '2' => '',
            '2' => '',
            '2' => '',
            '2' => '',
            '2' => '',
        ],
        "REQUIRE"
    );

if( $this->get("REQUIRE") == "EXIT" ) {
    $this->dismiss();
}

$this->shell_exec("wp package install " + $this->get("REQUIRE"));

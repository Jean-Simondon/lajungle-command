<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

$this->display("Ajout de dépendance")

    ->askInputKeyInArray(
        "Quel option utiliser ?",
        [
            '1' => 'EXIT',
            '2' => 'cache ',
            '2' => 'cache ',
            '2' => 'cache ',
            '2' => 'cache ',
            '2' => 'cache ',
            '2' => 'cache ',
            '2' => 'cache ',
            '2' => 'cache ',
            '2' => 'cache ',
            '2' => 'cache ',
        ],
        "REQUIRE"
    );

if( $this->get("REQUIRE") == "EXIT" ) {
    $this->dismiss();
}

$this->shell_exec("wp " + $this->get("REQUIRE"));

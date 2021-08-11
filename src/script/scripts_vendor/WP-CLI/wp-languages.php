<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

// https://developer.wordpress.org/cli/commands/language/

$this->display("Ajout de dépendance")

    ->askInputKeyInArray(
        "Quel option utiliser ?",
        [
            '1' => 'EXIT',
            '2' => "",

        ],
        "REQUIRE"
    );

if( $this->get("REQUIRE") == "EXIT" ) {
    $this->dismiss();
}


if( $this->get("REQUIRE") == "cap add 'author' 'role'" ) {

    $this->display("Quelle valeur pour author ?")
        ->askInputText("AUTHOR")
        ->display("Quelle valeur pour role ?")
        ->askInputText("ROLE")
        ->shell_exec("wp cap add '" + $this->get("AUTHOR") + "' '" + $this->get("ROLE") + "'" );

}


if( $this->get("REQUIRE") == "cap list 'role'" ) {

    $this->display("Quelle valeur pour role ?")
        ->askInputText("ROLE")
        ->shell_exec("wp cap list '" + $this->get("ROLE") + "'");

}






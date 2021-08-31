<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

$this->display("Outils de diagnostique")

    ->askInputKeyInArray(
        "Quelle option utiliser ?",
        [
            '1' => 'EXIT',
            '2' => 'post-type list',
            '3' => 'post-type get "slug"',
            '4' => 'plugin list',
        ],
        "CMD"
    );

if( $this->get("CMD") === 'EXIT' ) {

    $this->endScript();

} else {

    if( $this->get("CMD") === 'post-type get "slug"' ) {

        $this->display("Quelle valeur pour slug ?")
        ->askInputText("SLUG")
        ->shell_exec("wp post-type get " . $this->get("SLUG") );

    } else {
        $this->shell_exec("wp " . $this->get("CMD"));
    }

}
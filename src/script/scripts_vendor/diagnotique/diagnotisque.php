<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

$this->display("Ajout de dépendance")

    ->askInputKeyInArray(
        "Quel option utiliser ?",
        [
            '1' => 'EXIT',
            '2' => 'wp post-type list',
            '3' => 'wp post-type get "slug"',
            '4' => 'wp plugin list',
            '2' => '',
            '2' => '',
            '2' => '',
            '2' => '',
        ],
        "CMD"
    );

if( $this->get("CMD") == "EXIT" ) {
    $this->dismiss();
}

if( $this->get("CMD" === 'wp post-type get "slug"') ) {
    
    $this->shell_exec( $this->get("CMD") );

} else {

    $this->shell_exec( $this->get("CMD") );

}




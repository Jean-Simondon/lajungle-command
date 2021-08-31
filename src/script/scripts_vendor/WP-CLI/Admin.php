<?php

namespace Scripts;

use Validator\Validator;

// https://developer.wordpress.org/cli/commands/admin/
// Documentation sur les commandes admin

Validator::getInstance()->require([]);

$this->display("Outils d'administration")

    ->askInputKeyInArray(
        "Quelle option utiliser ?",
        [
            '1' => 'EXIT',
            '2' => 'admin',
            '3' => 'admin --skip-themes',
            '4' => 'admin --debug',
            '5' => 'admin --prompt',
            '6' => 'admin --user=<id\|login\|email>',
        ],
        "CMD"
    );

if( $this->get("CMD") === 'EXIT' ) {
    $this->endScript();
}

$this->shell_exec("wp " . $this->get("CMD"));

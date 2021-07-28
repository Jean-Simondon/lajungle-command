<?php

use Validator\Validator;

Validator::getInstance()
    ->require([

    ]);

$this->askInputNumber(
    "Action à réaliser",
    [
        '1' => 'Adds a value to the object cache',
        '2' => 'Decrements a value in the object cache',
        '3' => '',
        '4' => '',
        '5' => '',
        '6' => '',
        '7' => '',
        '8' => '',
        '9' => '',
        '10' => ''
    ],
    "CMD"
);

$this->display("Vous avez choisir : " . $this->get("CMD") );

// Est-ce que l'on continue ?
$this->display("Continuer [OoYy/Nn] : ")->askInputYesOrNo("CONTINUE");

if ($this->get("CONTINUE") == false) :
    $this->endScript();
endif;

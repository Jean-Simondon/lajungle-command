<?php

use Validator\Validator;

Validator::getInstance()
    ->require([

    ]);

    
$this->display("Downloads, installs, updates, and manages a WordPress installation.");
    
$this->askInputNumber(
    "Action à réaliser",
    [
        '1' => 'Install WordPress',
        '2' => 'Information Wordpress local',
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


if( $this->get("CMD") == "Install WordPress" ):

    $this->shell_exec("cd " . $project_root . "/ && php wp-cli.phar core check-update");

elseif( $this->get("CMD") == "Information Wordpress local" ):

elseif( $this->get("CMD") == "Install WordPress" ):

elseif( $this->get("CMD") == "Install WordPress" ):

elseif( $this->get("CMD") == "Install WordPress" ):

elseif( $this->get("CMD") == "Install WordPress" ):

elseif( $this->get("CMD") == "Install WordPress" ):

elseif( $this->get("CMD") == "Install WordPress" ):

elseif( $this->get("CMD") == "Install WordPress" ):

endif;
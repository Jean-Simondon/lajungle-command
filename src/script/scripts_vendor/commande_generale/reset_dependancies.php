<?php
 
 use Validator\Validator;

//  Validator::getInstance()
//      ->require([
//      ]);

$this->display("Ce script va supprimer les dépendances vendor et composer.lock, yYoO/nN");
$this->askInputYesOrNo("SKIP");
if( $this->get("SKIP") ) {
    $this->dismiss();
}

$this->display("Suppression de vendor/");
$this->shell_exec("cd " . LJD_PROJECT_ROOT . "/ && rm -r vendor");

$this->display("Suppression de composer.lock");
$this->shell_exec("cd " . LJD_PROJECT_ROOT . "/ && rm composer.lock");

$this->display("réinstallation des dépendances");
$this->shell_exec("cd " . LJD_PROJECT_ROOT . "/ && composer install");

$this->display("Pour supprimer plus de dépendances (plugins, cms, et autres, il faut écrire la suite du script");

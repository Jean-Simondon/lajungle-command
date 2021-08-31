<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()->require([]);

$this->display("Bienvenue dans l'assistant de création de post")

    ->display("Quel est le type du post ? (page, actualite, etc...")
    ->askInputText("TYPE")

    ->display("Combien de post à créer ?")
    ->askInputText("NUMBER")

    ->display("Créer " . $this->get("NUMBER") . " de " . $this->get("TYPE") . " ? [OoYy/Nn]")
    ->askInputYesOrNo("EXIT");

if( !$this->get("EXIT") ) {
    $this->endScript();
}

for( $i = 0; $i < $this->get("NUMBER"); $i++) {
    $this->shell_exec("wp post create --post_title='".$this->get("TYPE")." ".$i."' --post_type='".$this->get("TYPE")."' --post_status='publish'");
}

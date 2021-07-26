<?php

namespace Scripts;

use Validator\Validator;

Validator::getInstance()
    ->require([
        "project_type_is_know",
        "theme_dir_exists",
        "theme_exists",
        "bower_json_theme_exists"
    ]);

$this->shell_exec("cd " . THEME_PATH . "/ && bower install");

// use Scripts\Script;
// use Scripts\ScriptProvider;

// abstract class BowerInstall extends ScriptManager {

//     public function __construct() {

// 		parent::__construct();
// 	}

//     static function getRequire()
//     {
//         return [
//             "project_type_is_know",
//             "theme_dir_exists",
//             "theme_exists",
//             "bower_json_theme_exists"
//         ];
//     }

//     static function getMeta()
//     {
//         return [
//             'label' => "bower install"
//         ];
//     }

//     function execute()
//     {
//         $this->shell_exec("cd " . THEME_PATH . "/ && bower install");
//     }



// }
<?php

use Validator\Validator;

// Validator::getInstance()
//     ->require([
//         "project_type_is_know",
//         "theme_dir_exists",
//         "theme_exists",
//         "bower_json_theme_exists"
//     ]);

$this->shell_exec("cd " . STYLESHEETPATH . "/ && bower install");

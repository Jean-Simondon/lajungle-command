<?php

use Validator\Validator;

// Validator::getInstance()
//     ->require([
//         "project_type_is_know",
//         "composer_json_exist"
//     ]);

$this->shell_exec("cd " . LJD_PROJECT_ROOT . "/ && composer install");

<?php

WP_CLI::add_command("run_forest", "run_forest");

function run_forest() {
    echo realpath(".");
    shell_exec("cd " . realpath(".") . " && php index");
}

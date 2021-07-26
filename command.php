<?php

WP_CLI::add_command("run_forest", "run_forest");

function run_forest() {
    echo "Hello World";
    shell_exec("php index");
}

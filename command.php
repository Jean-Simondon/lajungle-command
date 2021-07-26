<?php

WP_CLI::add_command("run_forest", "run_forest");

function run_forest() {
    shell_exec("pwd");
    exec("./index-for-wp-cli.php");
}

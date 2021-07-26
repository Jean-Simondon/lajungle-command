<?php

WP_CLI::add_command("run_forest", "run_forest");

function run_forest() {
    require_once './index-for-wp-cli.php';
}

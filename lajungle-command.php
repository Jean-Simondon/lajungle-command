<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

function run_forest() {
    require_once __DIR__ . '/src/index-for-command.php';
}


WP_CLI::add_command("run-forest", "run_forest");

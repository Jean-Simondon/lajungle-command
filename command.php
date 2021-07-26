<?php

WP_CLI::add_command("start-jungle", "start_jungle");

function start_jungle() {
    exec("./index-for-wp-cli");
}

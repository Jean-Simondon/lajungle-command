<?php

WP_CLI::add_command("start-jungle", "run_forest");

function start_jungle() {
    exec("./index");
}

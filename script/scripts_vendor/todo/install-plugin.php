#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class InstallPlugin
{

    static function runCommand($plugin_name)
    {
        // echo realpath("");
        // echo __DIR__ . "/../vendor/bin/";
        echo shell_exec( __DIR__ . "/../vendor/bin/wp plugin install $plugin_name --activate");
    }

}

InstallPlugin::runCommand("bbpress");

// https://developer.wordpress.org/cli/commands/plugin/install/
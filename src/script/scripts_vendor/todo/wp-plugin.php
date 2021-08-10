#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class WPplugin
{

    static function runCommand()
    {
        echo shell_exec( __DIR__ . "/../vendor/bin/wp admin");
    }

}

WPplugin::runCommand();

// https://developer.wordpress.org/cli/commands/admin/
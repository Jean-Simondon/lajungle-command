#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class WPHelp
{

    static function runCommand()
    {
        echo shell_exec( __DIR__ . "/../vendor/bin/wp help");
    }

}

WPHelp::runCommand();

// https://developer.wordpress.org/cli/commands/admin/
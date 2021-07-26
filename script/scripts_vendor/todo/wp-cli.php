#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class WPCli
{

    static function runCommand()
    {
        echo shell_exec( __DIR__ . "/../vendor/bin/wp cli check-update");
    }

}

WPCli::runCommand();

// https://developer.wordpress.org/cli/commands/admin/
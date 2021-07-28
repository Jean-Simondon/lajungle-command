#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class WPCap
{

    static function runCommand()
    {
        echo shell_exec( __DIR__ . "/../vendor/bin/wp cap list 'contributor'");
    }

}

WPCap::runCommand();

// https://developer.wordpress.org/cli/commands/admin/
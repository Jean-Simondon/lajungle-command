#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class WPAdmin
{

    static function runCommand()
    {
        echo shell_exec( __DIR__ . "/../vendor/bin/wp admin");
    }

}

WPAdmin::runCommand();

// https://developer.wordpress.org/cli/commands/admin/
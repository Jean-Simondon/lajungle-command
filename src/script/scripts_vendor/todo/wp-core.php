#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class WPCore
{

    static function runCommand()
    {
        echo shell_exec( __DIR__ . "/../vendor/bin/wp language core install fr_FR");
    }

}

WPCore::runCommand();

// https://developer.wordpress.org/cli/commands/core/
#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class WPLanguage
{

    static function runCommand()
    {
        echo shell_exec( __DIR__ . "/../vendor/bin/wp language core install fr_FR");
    }

}

WPLanguage::runCommand();

// https://developer.wordpress.org/cli/commands/core/
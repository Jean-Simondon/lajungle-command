#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class WPCache
{

    static function runCommand()
    {
        echo shell_exec( __DIR__ . "/../vendor/bin/wp cache");
    }

}

WPCache::runCommand();

// https://developer.wordpress.org/cli/commands/cache/
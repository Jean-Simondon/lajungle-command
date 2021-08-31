#!/usr/bin/php
<?php

namespace LJD_CLI\Scripts;

class WPInfo
{

    static function runCommand()
    {
        echo shell_exec( realpath("..") . "/vendor/bin/wp --info");
    }

}

WPInfo::runCommand();

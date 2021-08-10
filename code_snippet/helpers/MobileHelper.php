<?php

namespace YOUR_THEME_NAME\Helpers;

class MobileHelper
{
    public static function isMobile()
    {
        $oDetect = new \Mobile_Detect;
        return $oDetect->isMobile() && !$oDetect->isTablet();
    }


    public static function isTablet()
    {
        $oDetect = new \Mobile_Detect;
        return $oDetect->isMobile() && $oDetect->isTablet();
    }


    public static function isDesktop()
    {
        $oDetect = new \Mobile_Detect;
        return !$oDetect->isMobile() && !$oDetect->isMobile();
    }
}
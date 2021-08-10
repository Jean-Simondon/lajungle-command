<?php
namespace YOUR_THEME_NAME\Helpers;

use Carbon\Carbon;

/**
 * Attention usage : tt dans les template
 */
class TranslateHelper
{
    private static $debug = false; // activer le mode debug pour écrire toutes les chaines de traduction dans un fichier

    public static function txt($string, $display = true)
    {
        if ( function_exists( 'pll__' ) ) {
            $retour = pll__($string);
            if(self::$debug){
                self::debug($string);
            }
        } else {
            $retour = $string;
        }
        if($display){
            echo $retour;
        }else{
            return $retour;
        }
    }

    public static function debug($string)
    {
        $file = dirname(__FILE__,7).'/translations-debug.txt';
        if($handler = fopen($file, 'a+')){
            fwrite($handler, sanitize_title($string).'|||'.$string.PHP_EOL);
            fclose($handler);
        }
    }
}

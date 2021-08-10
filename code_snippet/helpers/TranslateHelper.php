<?php

namespace YOUR_THEME_NAME\Helpers;

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

    /**
     * Remplace les oocurences jours et mois anglaises par des françaises dans une chaine de caractère
     */
    public static function englishDateToFrench($date)
    {
        $english_days = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ];
        $french_days = [ 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche' ];
        $english_months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
        $french_months = [ 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre' ];
        return str_replace($english_months, $french_months, str_replace( $english_days, $french_days, $date ) );
    }

    /**
     * Traduire des abréviations de mois Anglais en abréviation en français
     */
    public static function shortEnglishMonthToFrench($date)
    {
        $english_months = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'September', 'October', 'November', 'December' ];
        $french_months = [ 'jan', 'fév', 'mars', 'avr', 'mai', 'juin', 'juil', 'août', 'sept', 'oct', 'nov', 'déc' ];
        return str_replace($english_months, $french_months, $date );
    }

    /**
     * Remplace les occurences jours et mois françaises par des anglaises dans une chaine de caractère
     */
    public static function frenchDateToEnglish($date)
    {
        $english_days = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ];
        $french_days = [ 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche' ];
        $english_months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
        $french_months = [ 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre' ];
        return str_replace( $french_months, $english_months, str_replace( $french_days, $english_days, $date ) );
    }

}
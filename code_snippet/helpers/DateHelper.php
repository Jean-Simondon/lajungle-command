<?php

namespace YOUR_THEME_NAME\Helpers;

class DateHelper
{

    // https://www.php.net/manual/fr/class.datetime.php

    // date au format dd/mm/yyyy ou séparé par des . ou des -, renvoie le "d mois xxxx"
    public static function numericMonthtoFRString($date)
    {
        $month = ['', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
        if (strpos($date, "/")) {
            $date = explode('/', $date);
        } else if (strpos($date, "-")) {
            $date = explode('-', $date);
        } else if (strpos($date, ".")) {
            $date = explode('.', $date);
        } else {
            td("problème de format de date, choisir des séparateurs tel que '/', '-' ou '.', format actuel : $date");
        }
        if($date[0] < 10) {
            $date[0] = $date[0] % 10;
        }
        if($date[1] < 10) {
            $date[1] = $date[1] % 10;
        }

        if( count($date) == 3) {
            return $date[0] . ' ' . $month[$date[1]] . ' ' . $date[2];
        } else {
            return $date[0] . ' ' . $month[$date[1]];
        }

    }

    // public static function isAnterieur() {}

    // public static function isPosterieur() {}

    
    
}
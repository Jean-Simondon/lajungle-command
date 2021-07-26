<?php

namespace Validator;

use Exception;

class Validator
{

    private static $instance = null;

    public $container = [];

    /**
     * Selon les variables d'environnement, on charge des fichiers de configuration différent
     */
    private function __construct()
    {
        $this->container = require CONFIG_DIR . '/config-validator/validator.php';
        if (defined('PROJECT_TYPE')) {
            $this->container = array_merge(
                $this->container,
                require CONFIG_DIR . '/config-validator/validator-' . PROJECT_TYPE . '.php'
            );
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Validator();
        }
        return self::$instance;
    }

    /**
     * Pour chaque conditions passé en argument de la méthode
     * Le Validtor va appeler la condition dans le fichier de configuration config/config_validator/validator.php
     * Pour appeler sa fonction de callback.
     * Si elle renvoie faux, alors le message d'erreur associé est concaténé au message d'erreur globale
     * Si en fin de require, le message d'erreur globale n'est null (""), on lève une exception et on annule le lancement du script
     */
    function require($conditions)
    {
        $error_founded = "";

        if (isset($conditions) && is_array($conditions) && count($conditions) > 0) {
            foreach ($conditions as $condition) {

                if (!empty(self::getInstance()->container[$condition])) {

                    $result = self::getInstance()->container[$condition]["callback"]();

                    if ($result == false) {
                        $error_founded .= self::getInstance()->container[$condition]["error_message"] . "\n";
                    }
                }
            }

            // Si on a trouvé des manquements, on affiche le message
            if ($error_founded !== "") {
                $error_founded = "Le script ne peut être lancé car : \n\n" . $error_founded;
                throw new Exception($error_founded);
                return;
            }
        }

        return true;
    }
}

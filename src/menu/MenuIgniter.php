<?php

/**
 * 
 * Une classe afin de faire une requête sur le système de fichier et parser l'arborescence de fichier et lire dedans tout ce qu'il y a à lire
 * À l'initiation, va lire le système de fichier et produire la variable config-menu
 * 
 */

 /**
  * Stratégie :
  *
  * parcourir le répertoire script
  * constuire le menu en fonction des répertoires
  * constuire les options en fonction des scripts
  * dans meta : label du script 
  * appeler la clef code pour exécuter le code
  *
  */

  /**
   * 
   * faire un try catch
   * à la compilation
   * afin d'éviter des scripts qui ont les mêmes noms
   * 
   */

namespace Menu;

class MenuDAO
{

    static $config_menu;

	/**
	 * Constructeur privé, on simule ainsi une classe statique
	 */
	function __construct()
	{
		//Noop
	}

    function buildConfigMenu()
    {

        /**
         * On récupère le répertoire qui contient tous les scripts
         * pour chaque fichier finissant en php, mais qui n'est pas un meta.php
         * Alors on récupère la classe qu'il contient
         * et si elle extends ScriptProvider
         * Alors on l'enregistre dans le menu, ainsi que dans le container
         */

        scandir( SCRIPT_DIR . "/scripts_vendor" );

    }

    function getConfigMenu()
    {

    }

}
  
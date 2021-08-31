<?php

namespace Menu;

class MenuDAO
{
    public $config_menu;

    function __construct()
	{
        $this->config_menu = [];
        $this->config_menu = $this->buildConfigMenu( LJD_CMD_SCRIPT_DIR . "/scripts_vendor" );
        $this->config_menu["title"] = "Menu Principale";
	}

    private function buildConfigMenu($dirPath)
    {
        $config = [];
        if( is_dir( $dirPath ) ) {
            $config["title"] = str_replace("_", " ", basename($dirPath)); ;
            $dirInfo = scandir($dirPath);
            foreach($dirInfo as $fileName) {
                if('.gitkeep' == $fileName || "meta.php" == $fileName ||  "todo" == $fileName || '.' == $fileName || '..' == $fileName || str_contains($fileName, "exclude") ) {
                    continue;
                }
                if ( is_dir( $dirPath . DS . $fileName ) ) {
                    $config["submenus"][] = $this->buildConfigMenu( $dirPath . DS . $fileName ); // les sous menu
                }
                if ( is_file( $dirPath . DS . $fileName ) ) {
                    $config["scripts"][] = [
                        "label" => str_replace(["_", " ", ".php"], " ", $fileName), // nom de l'entrée dans le menu
                        "value" => str_replace( LJD_CMD_SCRIPT_DIR . DS , "", ( $dirPath . DS . $fileName ) ) // chemin pour lancer le script
                    ];
                }

                 // Voir pour plus tard
                 //Si la classe est de type à lancer, on lance l'initialisation.
                //  $sClassName = $sCurrentNs.substr($sFileName, 0, strpos($sFileName, '.'));
                //  if (
                //      is_subclass_of($sClassName, 'Iquitheme\\Core\\Features\\CptManager') ||
                //      is_subclass_of($sClassName, 'Iquitheme\\Core\\Features\\TaxoManager') ||
                //      is_subclass_of($sClassName, 'Iquitheme\\Core\\Features\\FeatureManager')
                //  ) {
                //      FeatureFactory::makeFeature($sClassName);
                //  }

            }

        }
        return $config;
    }

    public function getConfigMenu()
    {
        return $this->config_menu;
    }

}

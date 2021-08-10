<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;
use YOUR_THEME_NAME\Services\PolylangCreator;
use \WP_CLI;

class FeatureLocalization extends FeatureManager
{

    protected function _initHooks()
    {
        if( current_user_can('edit_posts')){ // seulement connectés avec droits d'admin
            add_action('init', [$this, 'localize']);
        }
        if ( class_exists( 'WP_CLI' ) ) {
            WP_CLI::add_command( 'polylangcreator', [$this, 'runCreator'], [
                'shortdesc'    => 'Extrait le debug de traduction, et nettoie le fichier',
            ]);
        }
    }

    /**
     * Déclaration des chaînes de traduction auprès de Polylang
     * Récupère le fichier translations.txt à la racine du projet pour alimenter la base.
     * Ce fichier est généré par la commade `wp polylangcreator` définie ci-dessous
     */
    public function localize()
    {
        $file = dirname(__FILE__,7).'/translations.txt';
        if(($handle = fopen($file, 'r')) !== false){
            while($elt = fgets($handle)){
                $exp = explode('|||', $elt);
                if(count($exp) == 2){
                    pll_register_string($exp[0], trim($exp[1]), 'Getlink');
                }
            }
            fclose($handle);
        }
    }

    /**
     * La méthode tt::txt (@see TranslationHelper) peut écrire (si le mode debug est activé) dans un fichier translation-debug.txt toutes les chaînes de traduction trouvées.
     * La présente commande va alors extraire toutes les données de ce fichier pour les dédoublonner et créer le fichier translation.txt utilisé par @see FeatureLocalization::localize()
     */
    public function runCreator()
    {
        $creator = new PolylangCreator();
        $creator->run();
    }
}

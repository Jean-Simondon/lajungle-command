<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;

class FeatureTranslate extends FeatureManager
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _initHooks()
    {
        add_filter( 'pll_translate_post_meta', [$this,'translate_post_meta'], 10, 3 ); //Gestion de la copie des metadonnées, lors de la traduction
    }

    public function translate_post_meta( $value, $key, $lang ) {
        $duplicate_options = get_user_meta( get_current_user_id(), 'pll_duplicate_content', true );
        if(isset($_GET['post_type']) && isset($duplicate_options[$_GET['post_type']]) && !empty($duplicate_options[$_GET['post_type']])){
            return $value;
        }

        return null;
    }

}
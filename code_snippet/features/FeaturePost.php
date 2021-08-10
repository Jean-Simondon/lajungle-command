<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;

use YOUR_THEME_NAME\Features\cpt\CptExample;

class FeaturePost extends FeatureManager
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _initHooks()
    {
      // Ajout des tags sur les pages
      add_filter('init', [$this, 'addTagsForPagesAndPost']);
    }

    public function addTagsForPagesAndPost()
    {
      register_taxonomy_for_object_type('post_tag', 'page');
      register_taxonomy_for_object_type('post_tag', \container()[CptExample::class]->getSlug());
  	}

}
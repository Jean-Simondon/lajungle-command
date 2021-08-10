<?php
namespace YOUR_THEME_NAME\Features;

use YOUR_THEME_NAME\Core\Features\FeatureManager;

use Dataterra\Features\cpt\CptExample;

class FeatureSearch extends FeatureManager
{

	protected function _initHooks()
	{
        add_filter( 'pre_get_posts', [$this, 'on_search_posts']);
        add_filter( 'pre_get_document_title', [$this, 'change_title'], 999, 1);
    }

    /**
     * Traduit l'onglet de la page de recherche
     */
    public function change_title($title)
    {
        // traduction de "You search for" par "Résultats de votre recherche" (dans l'onglet de la page web) quand on fait une recherche
        if( is_search() && function_exists( 'pll_current_language' ) && pll_current_language() == 'fr' ) {
            return 'Résultats de votre recherche : ' . substr($title, 16, strlen($title));
        }
        return $title;
    }

    public function on_search_posts($query)
    {

        if( !is_admin() && is_search() && $query->is_main_query() ) {

            $container = \container();

            $this->paged = intval(get_query_var('paged'));
            if($this->paged < 1){
                $this->paged = 1;
            }

            $query->set( 'post_type', [
                                    $container[CptExample::class]->getSlug(),
                                    'page'
                                    ]);

            $query->set( 'posts_per_page', 10 );
            $query->set( 'paged', $this->paged );

            if($this->paged > 1) {
                $query->set( 'offset', 10 * ($this->paged - 1) );
            }

        }

    }

}
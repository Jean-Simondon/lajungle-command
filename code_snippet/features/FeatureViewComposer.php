<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;

class FeatureViewComposer extends FeatureManager
{
	protected function _initHooks()
	{
		add_filter( 'init', [$this, 'initViewComposer'] );
	}

	public function initViewComposer()
	{

		\View::composer('elements.blocs.actualites', function($view) {
			$view->with('actualiteSlug', \container()[CptActualite::class]->getSlug());
		});

	}

}

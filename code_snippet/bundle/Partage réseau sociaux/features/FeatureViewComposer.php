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

		\View::composer('parts.share', function($view) {

			// On récupère l'indicateur de présence des icones de partage sur les réseaux sociaux
			$tabIcon = [];
			$email_content = "";

			if( get_field('icon-mail', 'option')) {
				$tabIcon[] = "email";
				// Construction du contenu du mail
				$email_content = "Contenu du mail";
			}
			if( get_field('icon-facebook', 'option') ) {
				$tabIcon[] = "facebook";
			}
			if( get_field('icon-linkedin', 'option') ) {
				$tabIcon[] = "linkedin";
			}
			if( get_field('icon-twitter', 'option') ) {
				$tabIcon[] = "twitter";
			}

			$view->with('tabIcon', $tabIcon)->with('email_content', $email_content);
		});

	}

}

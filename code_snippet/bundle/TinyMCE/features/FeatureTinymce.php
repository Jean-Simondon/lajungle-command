<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;

class FeatureTinymce extends FeatureManager
{
	protected function _initHooks()
	{
		if( current_user_can('edit_posts')){ // seulement pour ceux qui sont déjà connectés avec des droits d'admin
			// add_filter( 'tiny_mce_before_init', [$this, 'mceBeforeInit'] );
			add_action('init', [$this,'addButtons']);
		}
	}

    public function mceBeforeInit( $init_array )
    {
        // Suppression des titres h1
        $init_array['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Address=address;Pre=pre;';
        return $init_array;
    }

	public function addButtons()
	{
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
			return;
		}
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter('mce_external_plugins', [$this,'addPlugin']);
			add_filter('mce_buttons', [$this, 'registerButton']);
		}
	}

	public function registerButton($buttons)
	{
		array_push($buttons, ' | ', 'scbouton', 'scfichier', 'sctexte');
		return $buttons;
	}

	public function addPlugin($plugins)
	{
		$plugins['scbouton'] = iquitheme_assets(). '/js/tinymce.min.js';
		$plugins['scfichier'] = iquitheme_assets(). '/js/tinymce.min.js';
		$plugins['sctexte'] = iquitheme_assets(). '/js/tinymce.min.js';
		return $plugins;
	}
}

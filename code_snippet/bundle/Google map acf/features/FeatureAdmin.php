<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;

class FeatureAdmin extends FeatureManager
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _initHooks()
	{
		// Enregistrement de la Clef API pour Champ Google map
		add_action('acf/init', [$this, 'my_acf_init'], 10);
	}

	// Register API Key google map
	public function my_acf_init()
	{
		acf_update_setting('google_api_key', get_field("api-key-google-map", "option"));
	}

}

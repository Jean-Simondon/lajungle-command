<?php

namespace YOUR_THEME_NAME\Features\acf;

use YOUR_THEME_NAME\Features\cpt\CptExample;

use Iquitheme\Core\Features\FeatureManager;

use WordPlate\Acf\Location;

class ACFExample extends FeatureManager
{
	public function __construct()
	{
		parent::__construct();

		\register_extended_field_group([
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => ['the_content', 'discussion', 'comments'],
			'title' => 'Page d\'options examples',
			// 'title' => 'Page de contenu',
            // 'title' => 'Page d\'accueil',
            // 'title' => 'Paramètres technique',
            // 'title' => 'Paramètres du site',
			// 'title' => 'Page Template', // fait office de clef et doit être unique parmis toutes les autres features acf
			'fields' => [


			],
			'location' => [
				Location::if('options_page', 'acf-options-page-des-examples'),
				// Location::if('page_template', 'default')->and('page_type', '!=', 'front_page'),
				// Location::if('page_type', 'front_page'),
				// Location::if('options_page', 'acf-options-parametres-techniques'),
				// Location::if('options_page', 'acf-options-parametres-du-site'),
				// Location::if('page_template', 'template'), // clef depuis config/template ou cpt/cpt..../_mOptionsPage
			],
		]);
	}
}

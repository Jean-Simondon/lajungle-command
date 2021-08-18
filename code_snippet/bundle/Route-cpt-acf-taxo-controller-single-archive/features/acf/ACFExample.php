<?php

namespace YOUR_THEME_NAME\Features\acf;

use Iquitheme\Core\Features\FeatureManager;

use YOUR_THEME_NAME\Features\cpt\CptExample;

use YOUR_THEME_NAME\Acf\Models\ModuleExample;

use WordPlate\Acf\Location;

class ACFExample extends FeatureManager
{
	public function __construct()
	{
		parent::__construct();

		// CPT Example
		// \register_extended_field_group([
		// 	'menu_order' => 0,
		// 	'position' => 'normal',
		// 	'style' => 'default',
		// 	'label_placement' => 'top',
		// 	'instruction_placement' => 'label',
		// 	'hide_on_screen' => ['the_content', 'discussion', 'comments'],
		// 	'title' => 'Example', // mettre un slug ici
		// 	'fields' => [

		// 		ModuleExample::getAsField(),

		// 	],
		// 	'location' => [
		// 		Location::if('post_type', \container()[CptExample::class]->getSlug()),
		// 	],
		// ]);

		// Page d'options : Page examples
		// \register_extended_field_group([
		// 	'menu_order' => 0,
		// 	'position' => 'normal',
		// 	'style' => 'default',
		// 	'label_placement' => 'top',
		// 	'instruction_placement' => 'label',
		// 	'hide_on_screen' => ['the_content', 'discussion', 'comments'],
		// 	'title' => 'Page d\'options examples',
		// 	'fields' => [

		// 		ModuleExample::getAsField(),

		// 	],
		// 	'location' => [
		// 		Location::if('options_page', 'acf-options-page-des-examples'),
		// 	],
		// ]);
	}
}

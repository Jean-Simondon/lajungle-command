<?php

namespace YOUR_THEME_NAME\Features\acf;

use Iquitheme\Core\Features\FeatureManager;

use WordPlate\Acf\Fields\Text;

use WordPlate\Acf\Location;

class ACFOptions extends FeatureManager
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
            'title' => 'Paramètres technique',
            'fields' => [

                    Text::make('Clef API Google Map', 'api-key-google-map'),

                ],
            'location' => [
                Location::if('options_page', 'acf-options-parametres-techniques'),
            ],
        ]);
    }
}

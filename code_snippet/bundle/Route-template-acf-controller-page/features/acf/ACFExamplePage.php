<?php

namespace YOUR_THEME_NAME\Features\acf;

use Iquitheme\Core\Features\FeatureManager;

use WordPlate\Acf\Fields\Repeater;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\WysiwygEditor;
use WordPlate\Acf\Fields\Flexible;
use WordPlate\Acf\Fields\Layout;
use WordPlate\Acf\Fields\Textarea;
use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Number;
use WordPlate\Acf\Fields\Relationship;
use WordPlate\Acf\Fields\Oembed;
use WordPlate\Acf\Fields\TrueFalse;
use WordPlate\Acf\Fields\DateTimePicker;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\File;

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
            'title' => 'Example',
            'fields' => [


            ],
            'location' => [
                Location::if('page_template', 'example'),
            ],
        ]);
    }
}

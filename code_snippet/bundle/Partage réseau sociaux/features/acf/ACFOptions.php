<?php

namespace YOUR_THEME_NAME\Features\acf;

use Iquitheme\Core\Features\FeatureManager;

use WordPlate\Acf\Fields\Tab;
use WordPlate\Acf\Fields\TrueFalse;

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
            'title' => 'Paramètres du site',
            'fields' => [

                    // ICONE DE PARTAGE EN PIED DE PAGE ACTUALITE ET ETUDE CAS
                    Tab::make('Réseaux Sociaux')->placement('left'),

                    Group::make("Partage Réseaux sociaux", "partage-reseaux-sociaux")->fields([
                        TrueFalse::make('Activer icone de mail', 'icon-mail')
                            ->defaultValue('true')
                            ->stylisedUi('Présente', 'Absente')
                            ->wrapper(['width' => '50']),
                        TrueFalse::make('Activer icone Facebook', 'icon-facebook')
                            ->defaultValue('true')
                            ->stylisedUi('Présente', 'Absente')
                            ->wrapper(['width' => '50']),
                        TrueFalse::make('Activer icone Twitter', 'icon-twitter')
                            ->defaultValue('true')
                            ->stylisedUi('Présente', 'Absente')
                            ->wrapper(['width' => '50']),
                        TrueFalse::make('Activer icone Linkedin', 'icon-linkedin')
                            ->defaultValue('true')
                            ->stylisedUi('Présente', 'Absente')
                            ->wrapper(['width' => '50']),
                    ]),

                ],
            'location' => [
                Location::if('options_page', 'acf-options-parametres-du-site'),
            ],
        ]);

    }
}

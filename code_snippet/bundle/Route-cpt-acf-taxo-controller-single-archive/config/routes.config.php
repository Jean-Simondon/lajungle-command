<?php

/**
* Define all Route information for Iquitheme route system
*/
use YOUR_THEME_NAME\Features\cpt\CptExample;

$container = \container();

return [

    /**
    * Route de cpt
    */
    'persoCptRoutes' => [
        $container[CptExample::class]->getSlug() => 'ExampleController@archive',
    ],

    /**
    * Route single personnalisées
    */
    'persoSingleRoutes' => [
        'single-' . $container[CptExample::class]->getSlug() => 'ExampleController@single',
    ],

];

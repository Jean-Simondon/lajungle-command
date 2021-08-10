<?php

namespace YOUR_THEME_NAME\Acf\Models;

use WordPlate\Acf\Fields\Layout;
use WordPlate\Acf\Fields\Group;
use WordPlate\Acf\Fields\WysiwygEditor;

abstract class ModuleExample
{
    static $label = 'Example';
    static $key = 'example';

    /**
     * Renvoi le module sous la forme d'un layout
     */
    public static function getAsLayout()
    {
        return Layout::make( self::$label, self::$key )
        ->fields( self::getField() );
    }

    /**
     * Renvoi le module sous la forme d'un groupe
     */
    public static function getAsGroup()
    {
        return Group::make( self::$label, self::$key )
        ->fields( self::getField() );
    }

    /**
     * Renvoi le module sous la forme de champ
     */
    public static function getAsField()
    {
        return self::getField()[0];
    }

    /**
     * Définie le contendu du module
     */
    public static function getField()
    {
        return [
            WysiwygEditor::make("Contenu Texte", "texte"),
        ];
    }

}


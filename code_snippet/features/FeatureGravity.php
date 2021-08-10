<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;

/**
 * Cette classe gère l'apparence générale de GravityForms
 * Pour tout ce qui concerne la création de compte, login, etc, @see FeatureAccount
 */
class FeatureGravity extends FeatureManager
{

    protected function _initHooks()
    {
        // add_filter( 'gform_pre_render_1', [$this, 'setSelect'], 10, 2 );
    }

}
<?php

namespace YOUR_THEME_NAME\Features\cpt;

use Iquitheme\Core\Features\CptManager;

class CptExample extends CptManager
{
    public static $isDisabled = false;

    /**
     * surchage constructeur
     * @see  CptManager::__construct
     */
    public function __construct()
    {
        $this->forced_slug      =  __('example', THEME_TEXTDOMAIN);
        $this->_plural_name     = __('Examples', THEME_TEXTDOMAIN);
        $this->_singular_name   =  __('Example', THEME_TEXTDOMAIN);
        $this->_menu_icon       = 'dashicons-buddicons-groups';
        $this->_is_female       = false;
        $this->_mOptionsPage    = ['Page des examples'];
        // $this->_linkedTaxoClasses = [
        //     'YOUR_THEME_NAME\\Features\\taxo\\TaxoExample'
        // ];

        parent::__construct();
    }
}

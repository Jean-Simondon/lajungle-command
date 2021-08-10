<?php

namespace YOUR_THEME_NAME\Features\taxo;

use Iquitheme\Core\Features\TaxoManager;

class TaxoDomaine extends TaxoManager
{
	public static $isDisabled = false;

	public function __construct()
	{
		$this->_plural_name = __('Domaines', THEME_TEXTDOMAIN);
		$this->_singular_name =  __('Domaine', THEME_TEXTDOMAIN);
		$this->_forced_slug = 'domaine';
		$this->_is_female = false;
		$this->_use_radio_btn = true;
		$this->_attached_posttypes = [];
		
		parent::__construct();
	}
}

<?php

namespace YOUR_THEME_NAME\Features\taxo;

use Iquitheme\Core\Features\TaxoManager;

class TaxoExample extends TaxoManager
{
	public static $isDisabled = false;

	public function __construct()
	{
		$this->_plural_name = __('Examples', THEME_TEXTDOMAIN);
		$this->_singular_name =  __('Example', THEME_TEXTDOMAIN);
		$this->_forced_slug = 'example';
		$this->_is_female = false;
		$this->_use_radio_btn = true;
		$this->_attached_posttypes = [];

		parent::__construct();
	}
}

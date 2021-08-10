<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;

/**
 * @see : helpers/CookiebannerHelper.class.php
 */
class FeatureHeader extends FeatureManager
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _initHooks()
	{
		add_filter( 'body_class', [$this, 'addBodyClass']);
	}

	public function addBodyClass($aClasses)
	{
		//Ajout des classes de detection de type de devices
		if(class_exists('Mobile_Detect')){
			$oDetect = new \Mobile_Detect;

			if($oDetect->isMobile() && !$oDetect->isTablet()) {
				$aClasses[] = 'is-mobile';
			}
			if($oDetect->isTablet()) {
				$aClasses[] = 'is-tablet';
			}
			if(!$oDetect->isMobile() && !$oDetect->isTablet()) {
				$aClasses[] = 'is-desktop';
			}
		}
		return $aClasses;
	}
}

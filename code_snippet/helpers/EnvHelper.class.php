<?php
namespace YOUR_THEME_NAME\Helpers;

class EnvHelper
{
	static public function getEnv()
	{
		$retour = null;
		$rootPath = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
		if(file_exists($locations = $rootPath.DS.'config'.DS.'environment.php')){
			$locations = require($locations);
			$location = new \Thms\Config\Environment($rootPath,$locations);
			$retour = $location->which();
		}
		return $retour;
	}

	static public function is($val = '')
	{
		$retour = null;
		$rootPath = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
		if(file_exists($locations = $rootPath.DS.'config'.DS.'environment.php')){
			$locations = require($locations);
			$location = new \Thms\Config\Environment($rootPath,$locations);
			$retour = $location->which();
		}
		return $retour === $val;
	}
}

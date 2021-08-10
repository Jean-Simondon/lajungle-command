<?php
namespace YOUR_THEME_NAME\shortcodes;

use YOUR_THEME_NAME\Helpers\MediaHelper;

class ShortcodeFichier
{
	public static function sc_fichier($atts, $content = '')
	{
		$url = '';
		if(isset($atts['url'])){
			$url = $atts['url'];
		}
		if($content == '' && isset($atts['label'])){
			$content = $atts['label'];
		}
		return '<a href="'.$url.'" class="btn btn-primary download color2" download><span class="ico ico-download" aria-hidden="true">'.MediaHelper::displaySvg('download').'</span>'.$content.'</a>';
	}
}
add_shortcode('fichier', ['YOUR_THEME_NAME\shortcodes\ShortcodeFichier', 'sc_fichier']);

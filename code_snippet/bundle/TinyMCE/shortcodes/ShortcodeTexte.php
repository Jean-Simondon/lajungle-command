<?php
namespace YOUR_THEME_NAME\shortcodes;

class ShortcodeTexte
{
	public static function sc_texte($atts, $content = '')
	{
		return '<span class="highlight-text">'.$content.'</span>';
	}
}
add_shortcode('texte', ['YOUR_THEME_NAME\shortcodes\ShortcodeTexte', 'sc_texte']);

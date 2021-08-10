<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;
use Iquitheme\Helpers\EnvironmentHelper;

class FeatureThemeConfig extends FeatureManager
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _initHooks()
	{
		// -- suppression des action et scripts WP non désirés
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('admin_print_styles', 'print_emoji_styles');
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		add_action('init', [$this, 'deRegisterScripts']);
		// gestion des feuilles de styles chargés
		add_action('wp_enqueue_scripts', [$this, 'manageCss']);
		// gestion des scripts chargés
		add_action('wp_enqueue_scripts', [$this, 'manageJavascript']);
	}

	public function deRegisterScripts()
	{
		wp_deregister_script( 'comment-reply' );
		wp_deregister_script('heartbeat');
	}

	/**
	 * Gestion des fichiers de styles chargés
	 * @return [type] [description]
	 */
	public function manageCss()
	{
		wp_register_style('style', iquitheme_assets() . '/css/style.css', [], false, 'all');
        wp_enqueue_style('style');

        // wp_register_style('styleguide-style', iquitheme_assets() . '/css/styleguide.css', [], false, 'all');
		// wp_enqueue_style('styleguide-style');
	}

	/**
	 * Gestion des scripts JS chargés
	 * @return [type] [description]
	 */
	public function manageJavascript()
	{
		wp_deregister_script('jquery');
		wp_register_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js', [], '3.0.1', false );

		$assetsDir = dirname(dirname(__FILE__)).'/assets';
		if(EnvironmentHelper::is('local')||EnvironmentHelper::is('dev')) {
			if (file_exists($assetsDir.'/js/build/plugins.js')) {
		    	$mtime = filemtime($assetsDir.'/js/build/plugins.js');
		    	wp_register_script('plugins', iquitheme_assets() . '/js/build/plugins.js?v=1', ['jquery'], $mtime, true);
			}
		    if (file_exists($assetsDir.'/js/build/main.js')) {
		    	$mtime = filemtime($assetsDir.'/js/build/main.js');
		    	wp_register_script('main', iquitheme_assets() . '/js/build/main.js?v=1', ['jquery'], $mtime, true);
			}
		} else {
			if (file_exists($assetsDir.'/js/plugins.min.js')) {
		    	$mtime = filemtime($assetsDir.'/js/plugins.min.js');
		    	wp_register_script('plugins', iquitheme_assets() . '/js/plugins.min.js?v=1', ['jquery'], $mtime, true);
			}
		    if (file_exists($assetsDir.'/js/main.min.js')) {
		    	$mtime = filemtime($assetsDir.'/js/main.min.js');
		    	wp_register_script('main', iquitheme_assets() . '/js/main.min.js?v=1', ['jquery'], $mtime, true);
			}

			// wp_register_script('google_map', "https://maps.googleapis.com/maps/api/js?key=AIzaSyDLgxTYyZGUWb0AFFZLQD4-KBPTg9yZTXk" );
			
		}
        wp_enqueue_script('plugins');
        wp_enqueue_script('main');
		wp_enqueue_script('jquery');
		// wp_enqueue_script('google_map');
	}

	/**
	 * Chargement obligatoire de plugins spécifiques
	 */
	public function onPluginLoaded($plugins)
	{
		activate_plugin('advanced-custom-fields-pro/acf.php');
		// activate_plugin('polylang-pro/polylang.php');
		return $plugins;
	}

	public function spinner_url( $image_src, $form )
	{
		$assetsDir = dirname(dirname(__FILE__)).'/assets';
		if (file_exists($assetsDir.'/images/loader.gif')) {
		    return iquitheme_assets().'/images/loader.gif';
		}
	}

	/**
	 * Désactivation de l'API REST
	 * @see https://www.geekpress.fr/desactiver-rest-api-xml-rpc-wordpress/
	 */
	public function secureAPI( $result )
	{
	    if ( ! empty( $result ) ) {
	        return $result;
	    }
	    if ( ! is_user_logged_in() ) {
	        return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
	    }
	    return $result;
	  }

	  /**
	   * Éviter les problèmes d'encodage HTML des titres
	   */
	  public function fixTitleHtmlEntities ($title)
	  {
		  return html_entity_decode($title);
	  }


}

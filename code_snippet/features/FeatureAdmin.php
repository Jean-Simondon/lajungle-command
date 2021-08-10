<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;

class FeatureAdmin extends FeatureManager
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _initHooks()
	{
		// ----- gestion de la page de login
		add_filter('login_headerurl', [$this, 'customLoginURL']);
		add_action("login_head", [$this, "customLoginStyle"]);
		add_filter('login_headertext', [$this, 'customLoginTitle']);

		// ----- suppression des cpts tampons
		add_action('admin_menu', [$this, 'removeTmpCpt']);

		// On veut modifier l'ordre du menu dans l'admin
		add_filter('custom_menu_order', [$this, 'order_admin'], 10, 1);
		add_filter('menu_order', [$this, 'order_admin'], 10, 1);

		// afin d'autoriser l'uploade de fichier svg
		add_filter('upload_mimes', [$this, 'add_svg_to_upload_mimes'], 1, 1);

		if ( function_exists( 'get_field' ) ) {
			add_filter( 'acf/fields/wysiwyg/toolbars' , [$this, 'customize_toolbar_wysiwyg'] );
		}

		// au moment de sauvegarder la page "paramètre du site", on veut savoir si la popin est modifié, afin de l'afficher à nouveaux automatiquement la prochaine fois
		add_action('acf/save_post', [$this, 'on_save_popin'], 1);

		if (current_user_can('edit_posts')) { // seulement connectés avec droits d'admin
			// --- suppression de Gutenberg
			add_filter('use_block_editor_for_post', '__return_false');
			remove_filter('try_gutenberg_panel', 'wp_try_gutenberg_panel');
			add_action('init', [$this, 'acfOptionPage']);
		}

		// Enregistrement de la Clef API pour Champ Google map
		add_action('acf/init', [$this, 'my_acf_init'], 10);

		if( current_user_can('edit_posts')){ // seulement connectés avec droits d'admin
            // --- suppression de Gutenberg
            add_filter('use_block_editor_for_post', '__return_false');
			remove_filter( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );
			add_action( 'init', [$this, 'acfOptionPage'] );
		}

		// --- Gestion des inscrits simples (sans droits d'admin particulier)
		if(is_user_logged_in()) {
			$user = wp_get_current_user();
			$roles = ( array ) $user->roles;
			if(in_array('subscriber', $roles)){
				// masquage de la barre d'admin
				add_filter('show_admin_bar', '__return_false');
				// redirection vers la HP si tentative de rentrer dans l'admin
				add_filter('admin_init', function(){
					wp_redirect(home_url());
					exit();
				});
			}
		}

		if(WP_DEBUG === true && is_plugin_active('sucuri-scanner/sucuri.php')){
			add_action('admin_head', function()
			{
				echo '<style>body.php-error #adminmenuback, body.php-error #adminmenuwrap{ margin-top: 0;}</style>';
			});
		}
				

	}

    //===========================================================================
    //      Gestion de la page de login
    //===========================================================================

	/**
	 * Changer url lien logo
	 */
	public function customLoginURL()
	{
		return "/";
	}

	/**
	 * Changer le style de la page de login
	 * @return [type] [description]
	 */
	public function customLoginStyle()
	{
		echo "
			<style>
				body.login #login h1 a {
					background: url('" . iquitheme_assets() . "/images/logo-dci-group.jpg') 50% 50% no-repeat transparent;
					background-size: contain;
					width:280px;
					height:150px;
				}
			</style>
		";
	}

	/**
	 * Changer la balise title de la page de login
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 */
	public function customLoginTitle($message)
	{
		return get_bloginfo('name');
	}

    //===========================================================================
    //      Bloc ACF Google map
    //===========================================================================

	/**
	 * Register API Key google map
	 */
	public function my_acf_init()
	{
		acf_update_setting('google_api_key', option("api-key-google-map"));
	}

    //===========================================================================
    //      Organisation du menu 
    //===========================================================================

	/**
	 * Changer l'ordre des éléments
	 */
	function order_admin($menu_ord)
	{
		if (!$menu_ord) {
			return true;
		} else {
			return [
			'index.php',
			'edit.php?post_type=page',
			'edit.php?post_type=animation',
			'edit.php?post_type=galerie',
			'upload.php',
			'gf_edit_forms',
			'newsletter_la-seigneurie_option-page',
			'acf-options-parametres-du-site'
			];
		}
	}

	//===========================================================================
    //      Rajouter des pages avec ACF
    //===========================================================================

	public function acfOptionPage()
	{
		if (function_exists('acf_add_options_page')) {
			//Option de paramètre du site
			acf_add_options_page([
				'page_title'	=> 'Paramètres du site',
				'icon_url'		=> 'dashicons-desktop',
				'position'		=> 20,
			]);
			// Option de paramètres techniques
			acf_add_options_page([
				'page_title'	=> 'Paramètres techniques',
				'icon_url' => 'dashicons-admin-generic',
				'capability' => 'activate_plugins', // administrateur
				'position'		=> 31,
			]);
		}
	}

    //===========================================================================
    //      Cacher des pages du menu
    //===========================================================================

	public function removeTmpCpt()
	{
		remove_menu_page( 'edit.php?post_type=' . \container()[CptExampleTest::class]->getSlug() );
	}

	//===========================================================================
    //      Gestion des uploads
    //===========================================================================

	/**
	 * afin d'autoriser l'uploade de fichier svg
	 */
	public function add_svg_to_upload_mimes($upload_mimes)
	{
		if( current_user_can('edit_posts')) {
			$upload_mimes['ai'] = 'application/postscript';
			$upload_mimes['eps'] = 'application/postscript';
			$upload_mimes['svg'] = 'image/svg+xml';
			$upload_mimes['svgz'] = 'image/svg+xml';
		}

		return $upload_mimes;
	}



	//===========================================================================
    //      Custmisation des Wysiwyg
    //===========================================================================

	/**
	 * Customisation de la barre d'outils des wysiwyg
	 */
	function customize_toolbar_wysiwyg( $toolbars )
	{
		// On ajoute la possibilité de faire des exposants
		$toolbars['Full'][1][] = 'subscript';
		$toolbars['Full'][1][] = 'superscript';
		$toolbars['Full'][1][] = 'alignjustify';
		
		// Corrige l'absence de la seconde ligne de toolbar en ajoutant la second ligne dans la première
		// foreach($toolbars['Full'][2] as $tinyMce ) {
		// 	$toolbars['Full'][1][] = $tinyMce;
		// }

		/**
		 * Plus d'info avec https://www.wpexplorer.com/wordpress-tinymce-tweaks/
		 */

		return $toolbars;
	}

	// Register API Key google map
	public function my_acf_init()
	{
		acf_update_setting('google_api_key', get_field("api-key-google-map", "option"));
	}


}
